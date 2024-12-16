<?php

namespace SureCart\BlockLibrary;

/**
 * Provide general block-related functionality.
 */
class BlockPatternsService {
	/**
	 * Block patterns to register.
	 *
	 * @var array
	 */
	protected $patterns = [];

	/**
	 * Block patterns categories to register.
	 *
	 * @var array
	 */
	protected $categories = [];

	/**
	 * Set categories and patterns.
	 */
	public function __construct() {
		$this->categories = [
			'surecart_form' => [ 'label' => __( 'Checkout Form', 'surecart' ) ],
			'surecart_shop' => [ 'label' => __( 'Shop', 'surecart' ) ],
			'surecart_product_page' => [ 'label' => __( 'Product Page', 'surecart' ) ],
		];

		$this->patterns = [
			'default',
			'full-page',
			'simple',
			'sections',
			'two-column',
			'donation',
			'invoice',
		];
	}

	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'init', [ $this, 'registerPatternsAndCategories' ], 9 );
	}

	/**
	 * Register block patterns and
	 */
	public function registerPatternsAndCategories() {
		$this->registerCategories();
		$this->registerPatterns();
	}

	/**
	 * Register block pattern categories.
	 *
	 * @return void
	 */
	public function registerCategories() {
		/**
		 * Filters the block pattern categories.
		 *
		 * @param array[] $categories {
		 *     An associative array of block pattern categories, keyed by category name.
		 *
		 *     @type array[] $properties {
		 *         An array of block category properties.
		 *
		 *         @type string $label A human-readable label for the pattern category.
		 *     }
		 * }
		 */
		$this->categories = apply_filters( 'surecart/blocks/pattern_categories', $this->categories );

		foreach ( $this->categories as $name => $properties ) {
			if ( ! \WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
				register_block_pattern_category( $name, $properties );
			}
		}
	}

	/**
	 * Register our block patterns.
	 *
	 * @return void
	 */
	public function registerPatterns() {
		// register the block patterns from patterns directory.
		$patterns = glob( plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/patterns/*.php' );

		// sort by priority key.
		usort(
			$patterns,
			function ( $a, $b ) {
				$a = require $a;
				$b = require $b;
				return ( $a['priority'] ?? 0 ) <=> ( $b['priority'] ?? 0 );
			}
		);

		foreach ( $patterns as $pattern_file ) {
			register_block_pattern(
				'surecart-' . basename( $pattern_file, '.php' ),
				require $pattern_file
			);
		}

		/**
		 * Filters the plugin block patterns.
		 *
		 * @param array $patterns List of block patterns by name.
		 */
		$this->patterns = apply_filters( 'surecart/blocks/patterns', $this->patterns );

		// loop through patterns and register.
		foreach ( $this->patterns as $block_pattern ) {
			$pattern_file = plugin_dir_path( SURECART_PLUGIN_FILE ) . 'templates/forms/' . $block_pattern . '.php';

			register_block_pattern(
				'surecart/' . $block_pattern,
				require $pattern_file
			);
		}
	}
}
