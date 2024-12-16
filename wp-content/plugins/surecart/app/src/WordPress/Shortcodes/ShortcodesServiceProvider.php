<?php

namespace SureCart\WordPress\Shortcodes;

use SureCartBlocks\Blocks\AddToCartButton\Block as AddtoCartBlock;
use SureCartBlocks\Blocks\BuyButton\Block as BuyButtonBlock;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register shortcodes.
 */
class ShortcodesServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.shortcodes'] = function () {
			return new ShortcodesService();
		};
	}

	/**
	 * Bootstrap the service.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		add_shortcode( 'sc_line_item', '__return_false' );
		add_shortcode( 'sc_form', [ $this, 'formShortcode' ] );
		add_shortcode( 'sc_buy_button', [ $this, 'buyButtonShortcode' ], 10, 2 );

		// buttons.
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_dashboard_button',
			\SureCartBlocks\Blocks\CustomerDashboardButton\Block::class,
			[
				'show_icon' => true,
				'type'      => 'primary',
				'size'      => 'medium',
			]
		);

		// dashboard.
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_orders',
			\SureCartBlocks\Blocks\Dashboard\CustomerOrders\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_invoices',
			\SureCartBlocks\Blocks\Dashboard\CustomerInvoices\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_billing_details',
			\SureCartBlocks\Blocks\Dashboard\CustomerBillingDetails\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_charges',
			\SureCartBlocks\Blocks\Dashboard\Deprecated\CustomerCharges\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_payment_methods',
			\SureCartBlocks\Blocks\Dashboard\CustomerPaymentMethods\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_subscriptions',
			\SureCartBlocks\Blocks\Dashboard\CustomerSubscriptions\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_downloads',
			\SureCartBlocks\Blocks\Dashboard\CustomerDownloads\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_wordpress_account',
			\SureCartBlocks\Blocks\Dashboard\WordPressAccount\Block::class,
			[ 'title' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_dashboard_page',
			\SureCartBlocks\Blocks\Dashboard\CustomerDashboardArea\Block::class,
			[ 'name' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_dashboard',
			\SureCartBlocks\Blocks\Dashboard\CustomerDashboardArea\Block::class,
			[ 'name' => '' ]
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_customer_dashboard_tab',
			\SureCartBlocks\Blocks\Dashboard\DashboardTab\Block::class,
			[
				'icon'  => 'shopping-bag',
				'panel' => '',
				'title' => 'test',
			]
		);

		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_cart_menu_icon',
			\SureCartBlocks\Blocks\CartMenuButton\Block::class,
			[
				'cart_icon'              => 'shopping-bag',
				'cart_menu_always_shown' => true,
			]
		);

		// confirmation.
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_order_confirmation',
			\SureCartBlocks\Blocks\Confirmation\Block::class,
		);
		$container['surecart.shortcodes']->registerBlockShortcode(
			'sc_order_confirmation_line_items',
			\SureCartBlocks\Blocks\OrderConfirmationLineItems\Block::class,
		);

		// product page.
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_list',
			'surecart/product-item-list',
			[
				'ids'                => [],
				'columns'            => 4,
				'sort_enabled'       => true,
				'search_enabled'     => true,
				'pagination_enabled' => true,
				'ajax_pagination'    => true,
				'collection_enabled' => true,
				'type'               => 'all',
				'limit'              => 10,
			]
		);

		// Product collection page.
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_collection',
			'surecart/product-collection',
			[
				'collection_id'      => '', // mandatory.
				'columns'            => 4,
				'sort_enabled'       => true,
				'search_enabled'     => true,
				'pagination_enabled' => true,
				'ajax_pagination'    => true,
				'limit'              => 10,
			]
		);

		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_description',
			'surecart/product-description',
			[
				'id' => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_title',
			'surecart/product-title',
			[
				'level' => 1,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_price',
			'surecart/product-price',
			[
				'id' => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_price_choices',
			'surecart/product-price-choices',
			[
				'label'      => __( 'Pricing', 'surecart' ),
				'columns'    => 2,
				'show_price' => true,
				'id'         => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_media',
			'surecart/product-media',
			[
				'auto_height' => true,
				'id'          => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_quantity',
			'surecart/product-quantity',
			[
				'id' => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_cart_button',
			'surecart/product-buy-button',
			[
				'add_to_cart' => true,
				'text'        => __( 'Add To Cart', 'surecart' ),
				'width'       => 100,
				'id'          => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_variant_choices',
			'surecart/product-variant-choices',
			[
				'id' => null,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_add_to_cart_button',
			'surecart/add-to-cart-button',
			[
				'price_id'    => null,
				'variant_id'  => null,
				'type'        => 'primary',
				'size'        => 'medium',
				'button_text' => __( 'Add To Cart', 'surecart' ),
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_collection_tags',
			'surecart/product-collection-tags',
			[
				'id'    => null,
				'count' => 1,
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_custom_amount',
			'surecart/product-selected-price-ad-hoc-amount',
			[
				'label' => __( 'Enter an amount', 'surecart' ),
			]
		);
		$container['surecart.shortcodes']->registerBlockShortcodeByName(
			'sc_product_page',
			'surecart/product-page',
			[
				'id' => null,
			]
		);

		// generate shortcodes for all our blocks.
		foreach ( glob( SURECART_PLUGIN_DIR . '/packages/blocks-next/build/blocks/**/block.json' ) as $file ) {
			$metadata = wp_json_file_decode( $file, array( 'associative' => true ) );
			$name     = str_replace( 'surecart/', '', $metadata['name'] );
			$name     = str_replace( '-', '_', sanitize_title_with_dashes( $name ) );

			$old_shortcode_names = [
				'product_title',
				'product_description',
				'product_quantity',
				'product_media',
			];

			if ( in_array( $name, $old_shortcode_names, true ) ) {
				$name = $name . '_new';
			}

			$container['surecart.shortcodes']->registerBlockShortcodeByName(
				'sc_' . $name,
				$metadata['name'],
			);
		}
	}

	/**
	 * Dashboard tab shortcode.
	 *
	 * @param  array  $attributes Shortcode attributes.
	 * @param  string $content Shortcode content.
	 * @return string Shortcode output.
	 */
	public function dashboardShortcode( $attributes, $content ) {
		$attributes = shortcode_atts(
			[],
			$attributes,
			'sc_customer_dashboard'
		);

		return '<sc-tab-group style="font-size:16px;font-family:var(--sc-font-sans)" class="wp-block-surecart-customer-dashboard alignwide">' . ( new \SureCartBlocks\Blocks\Dashboard\CustomerDashboard\Block() )->render( $attributes, $content ) . '</sc-tab-group>';
	}

	/**
	 * Form shorcode
	 *
	 * @param  array  $atts Shortcode attributes.
	 * @param  string $content Shortcode content.
	 * @param  string $name Shortcode tag.
	 *
	 * @return string Shortcode output.
	 */
	public function formShortcode( $atts, $content, $name ) {
		$atts = shortcode_atts(
			[
				'id' => null,
			],
			$atts,
			'sc_form'
		);

		if ( ! $atts['id'] ) {
			return;
		}

		$form = \SureCart::forms()->get( $atts['id'] );

		global $load_sc_js;
		$load_sc_js = true;

		global $sc_form_id;
		$sc_form_id = $atts['id'];

		// check to make sure we have a form post.
		if ( ! is_a( $form, 'WP_Post' ) ) {
			return __( 'This form is not available or has been deleted.', 'surecart' );
		}

		return apply_filters( 'surecart/shortcode/render', do_blocks( $form->post_content ), $atts, $name, $form );
	}

	/**
	 * Buy button shortcode.
	 *
	 * @param array  $atts An array of attributes.
	 * @param string $content Content.
	 *
	 * @return string
	 */
	public function buyButtonShortcode( $atts, $content ) {
		// Remove inner shortcode from buy button label.
		$label = strip_shortcodes( $content );
		$atts  = shortcode_atts(
			[
				'type'  => 'primary',
				'size'  => 'medium',
				'label' => $label,
			],
			$atts,
			'sc_buy_button'
		);

		$atts['line_items'] = (array) $this->getShortcodesAtts(
			'sc_line_item',
			$content,
			[
				'price_id' => null,
				'quantity' => 1,
			]
		);

		foreach ( $atts['line_items'] as $key => $line_item ) {
			$atts['line_items'][ $key ]['id'] = $line_item['price_id'];
		}

		$block = new BuyButtonBlock();

		return $block->render( $atts );
	}

	/**
	 * Get specific shortcode atts from content
	 *
	 * @param string $name Name of shortcode.
	 * @param string $content Page content.
	 * @param array  $defaults Defaults for each.
	 * @return array
	 */
	public function getShortcodesAtts( $name, $content, $defaults = [] ) {
		$items = [];

		// if shortcode exists.
		if (
		preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches )
		&& array_key_exists( 2, $matches )
		&& in_array( $name, $matches[2] )
		) {
			foreach ( (array) $matches[0] as $key => $value ) {
				if ( strpos( $value, $name ) !== false ) {
					$items[] = wp_parse_args(
						shortcode_parse_atts( $matches[3][ $key ] ),
						$defaults
					);
				}
			}
		}

		return $items;
	}

	/**
	 * Convert to block.
	 *
	 * @param string   $name The name.
	 * @param stdClass $block The block.
	 * @param array    $defaults The defaults.
	 * @param array    $atts The atts.
	 * @param string   $content The content.
	 *
	 * @return string
	 */
	protected function convertToBlock( $name, $block, $defaults = [], $atts = [], $content = '' ) {
		return( new $block() )->render(
			shortcode_atts(
				$defaults,
				$atts,
				$name
			),
			$content
		);
	}
}
