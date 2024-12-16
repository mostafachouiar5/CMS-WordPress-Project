<?php
namespace SureCart\WordPress\Assets;

use SureCart\Support\Arrays;

/**
 * Handles the preloading functionality for components.
 */
class PreloadService {
	/**
	 * The stats file path.
	 *
	 * @var string
	 */
	protected $stats_file;

	/**
	 * Components to preload.
	 *
	 * @var array
	 */
	protected $components = [];

	/**
	 * Get the stats file path
	 *
	 * @param string $stats_file The stats file path.
	 */
	public function __construct( $stats_file ) {
		$this->stats_file = $stats_file;
	}

	/**
	 * Bootstrap the preload.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// add preload tags to head, footer as fallback.
		add_action( 'wp_head', [ $this, 'renderComponents' ] );
		add_action( 'wp_footer', [ $this, 'renderComponents' ] );
	}

	/**
	 * Get the bundle stats file.
	 *
	 * @return object|false;
	 */
	protected function getStatsFile() {
		if ( ! file_exists( $this->stats_file ) ) {
			return false;
		}
		return wp_json_file_decode( $this->stats_file, [ 'associative' => true ] );
	}

	/**
	 * Get the filenames from the stats.
	 *
	 * @param array  $components An array of component names.
	 * @param string $format The format we are using.
	 *
	 * @return array
	 */
	public function getFileNames( $components, $format = 'esmBrowser' ) {
		$json    = $this->getStatsFile();
		$entries = $json['formats'][ $format ] ?? [];

		$set = array_map(
			function( $element ) use ( $entries ) {
				$files              = [];
				$collection_bundles = array_filter(
					$entries,
					function( $entry ) use ( $element ) {
						return in_array( $element, $entry['components'], true );
					}
				);

				foreach ( $collection_bundles as $bundle ) {
					$files = array_merge( [ $bundle['fileName'] ], $bundle['imports'] );
				}

				return $files;
			},
			$components
		);

		return array_unique( Arrays::flatten( $set ) );
	}

	/**
	 * Render the components
	 *
	 * @return void
	 */
	public function renderComponents() {
		// For Single product page, we no longer need to preload the components.
		if ( is_singular( 'sc_product' ) ) {
			return;
		}

		if ( ! empty( $this->components ) ) {
			$this->renderTag( $this->components );
			$this->components = [];
		}
	}

	/**
	 * Render the preload tags.
	 *
	 * @param array  $components An array of components.
	 * @param string $format The format.
	 * @param string $path The path to the component javascript file.
	 *
	 * @return void
	 */
	public function renderTag( $components, $format = 'esmBrowser', $path = 'dist/components/surecart/' ) {
		if ( empty( $components ) ) {
			return;
		}

		$names = $this->getFileNames( $components, $format );

		if ( empty( $names ) ) {
			return;
		}

		foreach ( $names as $name ) {
			echo "<link rel='preload' href='" . esc_url( trailingslashit( \SureCart::core()->assets()->getUrl() ) . trailingslashit( $path ) . $name ) . "' as='script' crossorigin />\n";
		}
	}

	/**
	 * Add preload components.
	 *
	 * @param array $components Component names.
	 *
	 * @return void
	 */
	public function add( $components ) {
		$this->components = array_filter( array_unique( array_merge( $this->components, $components ) ) );
	}
}
