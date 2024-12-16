<?php

namespace SureCart\Support\Scripts;

use SureCart\Models\Account;
use SureCart\Support\Currency;

/**
 * Class for model edit pages to extend.
 */
abstract class AdminModelEditController {
	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = '';

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = '';

	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'links' ];

	/**
	 * Additional dependencies
	 *
	 * @var array
	 */
	protected $dependencies = [ 'sc-core-data', 'sc-ui-data' ];

	/**
	 * Data to pass to the page.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Optional conditionally load.
	 */
	protected function condition() {
		return true;
	}

	/**
	 * Enqueue needed scripts
	 *
	 * @return void
	 */
	public function enqueueScriptDependencies() {
		wp_enqueue_media();
		wp_enqueue_style( 'wp-components' );
		wp_enqueue_style( 'wp-editor' );
	}

	public function enqueueComponents() {
		wp_enqueue_script( 'surecart-components' );
		wp_enqueue_style( 'surecart-themes-default' );
		wp_add_inline_style(
			'surecart-themes-default',
			':root { --sc-color-primary-text: #fff; }' // this is important in case the user has a dark primary text.
		);
		wp_add_inline_style(
			'surecart-themes-default',
			'.sc-dragging { z-index: 1 }' // this is required for dragging.
		);
	}

	/**
	 * Enqueue scripts
	 *
	 * @return void
	 */
	public function enqueue() {
		if ( ! $this->condition() ) {
			return;
		}

		// components are also used on index pages.
		$this->enqueueComponents();

		// match url query for the scripts.
		if ( ! empty( $this->url_query ) ) {
			foreach ( $this->url_query as $param => $value ) {
				// phpcs:ignore
				if ( ! isset( $_GET[ $param ] ) || $value !== sanitize_text_field( wp_unslash( $_GET[ $param ] ) ) ) {
					return;
				}
			}
		}

		// enqueue dependencies.
		$this->enqueueScriptDependencies();

		// fix shitty jetpack issues key hijacking issues.
		add_filter(
			'admin_head',
			function() {
				wp_dequeue_script( 'wpcom-notes-common' );
				wp_dequeue_script( 'wpcom-notes-admin-bar' );
				wp_dequeue_style( 'wpcom-notes-admin-bar' );
				wp_dequeue_style( 'noticons' );
			},
			200
		);

		// automatically load dependencies and version.
		$asset_file = include plugin_dir_path( SURECART_PLUGIN_FILE ) . "dist/$this->path.asset.php";

		// Enqueue scripts.
		wp_enqueue_script(
			$this->handle,
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . "dist/$this->path.js",
			array_merge( $asset_file['dependencies'], $this->dependencies ),
			$asset_file['version'],
			true
		);

		// pass app url.
		$this->data['upgrade_url']          = \SureCart::config()->links->purchase;
		$this->data['surecart_app_url']     = defined( 'SURECART_APP_URL' ) ? SURECART_APP_URL : '';
		$this->data['account_id']           = \SureCart::account()->id ?? '';
		$this->data['account_slug']         = \SureCart::account()->slug ?? '';
		$this->data['api_url']              = \SureCart::requests()->getBaseUrl();
		$this->data['plugin_url']           = \SureCart::core()->assets()->getUrl();
		$this->data['home_url']             = untrailingslashit( get_home_url() );
		$this->data['buy_page_slug']        = untrailingslashit( \SureCart::settings()->permalinks()->getBase( 'buy_page' ) );
		$this->data['product_page_slug']    = untrailingslashit( \SureCart::settings()->permalinks()->getBase( 'product_page' ) );
		$this->data['collection_page_slug'] = untrailingslashit( \SureCart::settings()->permalinks()->getBase( 'collection_page' ) );
		$this->data['is_block_theme']       = \SureCart::utility()->blockTemplates()->isFSETheme();
		$this->data['claim_url']            = ! \SureCart::account()->claimed ? \SureCart::routeUrl( 'account.claim' ) : '';

		if ( in_array( 'currency', $this->with_data ) ) {
			$this->data['currency_code'] = \SureCart::account()->currency;
		}
		if ( in_array( 'tax_protocol', $this->with_data ) ) {
			$this->data['tax_protocol'] = \SureCart::account()->tax_protocol;
		}
		if ( in_array( 'shipping_protocol', $this->with_data ) ) {
			$this->data['shipping_protocol'] = \SureCart::account()->shipping_protocol;
		}
		if ( in_array( 'checkout_page_url', $this->with_data ) ) {
			$this->data['checkout_page_url'] = \SureCart::getUrl()->checkout();
		}
		if ( in_array( 'supported_currencies', $this->with_data ) ) {
			$this->data['supported_currencies'] = Currency::getSupportedCurrencies();
		}
		if ( in_array( 'links', $this->with_data ) ) {
			$this->data['links'] = [];
			foreach ( array_keys( \SureCart::getAdminPageNames() ) as $name ) {
				$this->data['links'][ $name ] = esc_url_raw( add_query_arg( [ 'action' => 'edit' ], \SureCart::getUrl()->index( $name ) ) );
			}
		}

		// pass entitlements to page.
		$this->data['entitlements'] = \SureCart::account()->entitlements;
		$this->data['get_locale']   = str_replace( '_', '-', get_locale() );

		wp_set_script_translations( $this->handle, 'surecart' );

		// common localizations.
		wp_localize_script(
			$this->handle,
			'scData',
			apply_filters( "$this->handle/data", $this->data )
		);

		wp_localize_script( $this->handle, 'scIcons', [ 'path' => esc_url_raw( plugin_dir_url( SURECART_PLUGIN_FILE ) . 'dist/icon-assets' ) ] );

		// custom localizations.
		$this->localize( $this->handle );
	}

	protected function localize( $handle ) {
	}
}
