<?php
/**
 * PreloadService class file.
 *
 * This file contains the PreloadService class which handles preloading of components.
 *
 * @package PrestoPlayer
 * @subpackage Services
 */

namespace PrestoPlayer\Services;

use PrestoPlayer\Support\Utility;

/**
 * Class PreloadService
 *
 * Handles the preloading of components for Presto Player.
 */
class PreloadService {

	/**
	 * The stats file path.
	 *
	 * @var string
	 */
	protected $stats_file = PRESTO_PLAYER_PLUGIN_DIR . 'dist/components/stats.json';

	/**
	 * Components to preload.
	 *
	 * @var array
	 */
	protected $components = array();

	/**
	 * Bootstrap the preload.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// Preload components.
		add_action( 'wp_head', array( $this, 'renderComponents' ) );
		add_action( 'wp_footer', array( $this, 'renderComponents' ) );
	}

	/**
	 * Render the components
	 *
	 * @return void
	 */
	public function renderComponents() {
		if ( ! empty( $this->components ) ) {
			$this->renderTag( $this->components );
			$this->components = array();
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
	public function renderTag( $components, $format = 'esmBrowser', $path = 'dist/components/web-components/' ) {
		if ( empty( $components ) ) {
			return;
		}

		$names = $this->getFileNames( $components, $format );

		if ( empty( $names ) ) {
			return;
		}

		foreach ( $names as $name ) {
			echo "<link rel='modulepreload' href='" . esc_url( trailingslashit( PRESTO_PLAYER_PLUGIN_URL ) . trailingslashit( $path ) . $name ) . "' as='script' crossorigin />\n";
		}
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
		return wp_json_file_decode( $this->stats_file, array( 'associative' => true ) );
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
		$entries = $json['formats'][ $format ] ?? array();

		$set = array_map(
			function ( $element ) use ( $entries ) {
				$files              = array();
				$collection_bundles = array_filter(
					$entries,
					function ( $entry ) use ( $element ) {
						return in_array( $element, $entry['components'], true );
					}
				);

				foreach ( $collection_bundles as $bundle ) {
					$files = array_merge( array( $bundle['fileName'] ), $bundle['imports'] );
				}

				return $files;
			},
			$components
		);

		return array_unique( Utility::flatten( $set ) );
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
