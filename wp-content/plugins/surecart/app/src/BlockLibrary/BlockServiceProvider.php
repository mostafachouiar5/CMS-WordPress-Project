<?php

/**
 * Block Service Provider
 */

namespace SureCart\BlockLibrary;

use SureCart\BlockLibrary\BlockService;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Block Service Provider Class
 * Registers block service used throughout the plugin
 *
 * @author  SureCart <andre@surecart.com>
 * @since   1.0.0
 * @license GPL
 */
class BlockServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$app = $container[ SURECART_APPLICATION_KEY ];

		$container['block'] = function () use ( $app ) {
			return new BlockService( $app );
		};

		$container['block.support.anchor'] = function () use ( $app ) {
			return new BlockAnchorSupportService();
		};

		$container['blocks.patterns'] = function () use ( $app ) {
			return new BlockPatternsService( $app );
		};

		$container['blocks.validations'] = function () {
			return new BlockValidationService(
				apply_filters(
					'surecart_block_validators',
					array(
						new \SureCart\BlockValidator\VariantChoice(),
					)
				)
			);
		};

		$container['blocks.mode_switcher'] = function () use ( $app ) {
			return new FormModeSwitcherService( $app );
		};

		$app->alias( 'block', 'block' );

		// Register blocks.
		include plugin_dir_path( SURECART_PLUGIN_FILE ) . 'packages/blocks-next/index.php';
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 *
	 * @return void
	 *
	 * phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter
	 */
	public function bootstrap( $container ) {
		$container['blocks.patterns']->bootstrap();
		$container['blocks.validations']->bootstrap();
		$container['blocks.mode_switcher']->bootstrap();
		$container['block.support.anchor']->bootstrap();

		// allow design tokens in css.
		add_filter(
			'safe_style_css',
			function ( $styles ) {
				return array_merge(
					array(
						'--spacing',
						'--font-weight',
						'--line-height',
						'--font-size',
						'--text-align',
						'--color',
						'--sc-input-label-color',
						'--primary-background',
						'--primary-color',
						'--sc-color-primary-text',
						'--sc-color-primary-500',
						'--sc-focus-ring-color-primary',
						'--sc-input-border-color-focus',
					),
					$styles
				);
			}
		);
		// allow our web components in wp_kses contexts.
		add_filter( 'wp_kses_allowed_html', array( $this, 'ksesComponents' ) );
		// register our blocks.
		add_action( 'init', array( $this, 'registerBlocks' ) );
		// register our category.
		add_action( 'block_categories_all', array( $this, 'registerBlockCategories' ) );
	}

	/**
	 * Register our custom block category.
	 *
	 * @param array $categories Array of categories.
	 * @return array
	 */
	public function registerBlockCategories( $categories ) {
		return array(
			...array(
				array(
					'slug'  => 'surecart',
					'title' => esc_html__( 'Checkout', 'surecart' ),
				),
				array(
					'slug'  => 'surecart-customer-dashboard',
					'title' => esc_html__( 'Customer Dashboard', 'surecart' ),
				),
				array(
					'slug'  => 'surecart-cart',
					'title' => esc_html__( 'Cart', 'surecart' ),
				),
				array(
					'slug'  => 'surecart-product-list',
					'title' => esc_html__( 'Shop', 'surecart' ),
				),
				array(
					'slug'  => 'surecart-product-page',
					'title' => esc_html__( 'Product', 'surecart' ),
				),
				array(
					'slug'  => 'surecart-upsell-page',
					'title' => esc_html__( 'Upsells', 'surecart' ),
				),
			),
			...$categories,
		);
	}

	/**
	 * Add iFrame to allowed wp_kses_post tags
	 *
	 * @param array $tags Allowed tags, attributes, and/or entities.
	 *
	 * @return array
	 */
	public function ksesComponents( $tags ) {
		$components = json_decode( file_get_contents( plugin_dir_path( SURECART_PLUGIN_FILE ) . 'app/src/Support/kses.json' ), true );

		// add slot to defaults.
		$tags['span']['slot']         = true;
		$tags['div']['slot']          = true;
		$tags['sc-spinner']['data-*'] = true;

		return array_merge( $components, $tags );
	}

	/**
	 * Register blocks from config
	 *
	 * @return void
	 */
	public function registerBlocks() {
		$service = \SureCart::resolve( SURECART_CONFIG_KEY );
		if ( ! empty( $service['blocks'] ) ) {
			foreach ( $service['blocks'] as $block ) {
				( new $block() )->register();
			}
		}
	}
}
