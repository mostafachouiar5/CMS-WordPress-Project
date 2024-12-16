<?php

namespace SureCart\Controllers\Admin\Settings;

use SureCart\Models\Processor;
use SureCart\Support\Currency;
use SureCart\Support\TimeDate;

/**
 * Controls the settings page.
 */
abstract class BaseSettings {
	/**
	 * Script handles for pages
	 *
	 * @var array
	 */
	protected $scripts = [];

	/**
	 * The template for the page.
	 *
	 * @var string
	 */
	protected $template = 'admin/settings-page';

	/**
	 * Additional dependencies for this page.
	 *
	 * @var array
	 */
	protected $dependencies = [];

	/**
	 * Tabs for the page.
	 *
	 * @var array
	 */
	protected $tabs = [];

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->tabs = [
			'brand'                          => __( 'Design & Branding', 'surecart' ),
			'order'                          => __( 'Orders & Invoices', 'surecart' ),
			'abandoned_checkout'             => __( 'Abandoned Checkout', 'surecart' ),
			'customer_notification_protocol' => __( 'Notifications', 'surecart' ),
			'subscription_protocol'          => __( 'Subscriptions', 'surecart' ),
			'subscription_preservation'      => __( 'Subscription Saver', 'surecart' ),
			'tax_protocol'                   => __( 'Taxes', 'surecart' ),
			'processors'                     => __( 'Payment Processors', 'surecart' ),
			'export'                         => __( 'Data Export', 'surecart' ),
			'connection'                     => __( 'Connection', 'surecart' ),
			'advanced'                       => __( 'Advanced', 'surecart' ),
		];
	}

	/**
	 * Show the page.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return function
	 */
	public function show( \SureCartCore\Requests\RequestInterface $request ) {
		// don't show admin notices on settings pages.
		remove_all_actions( 'admin_notices' );

		add_action( 'admin_enqueue_scripts', [ $this, 'showScripts' ] );

		return \SureCart::view( $this->template )->with(
			[
				'tab'          => $request->query( 'tab' ) ?? '',
				'breadcrumb'   => ! empty( $this->tabs[ $request->query( 'tab' ) ?? '' ] ) ? $this->tabs[ $request->query( 'tab' ) ?? '' ] : '',
				'is_free'      => (bool) ( \SureCart::account()->plan->free ?? true ),
				'entitlements' => \SureCart::account()->entitlements,
				'upgrade_url'  => \SureCart::config()->links->purchase,
				'brand_color'  => \SureCart::account()->brand->color ?? null,
				'status'       => $request->query( 'status' ),
				'claim_url'    => ! \SureCart::account()->claimed ? \SureCart::routeUrl( 'account.claim' ) : '',
			]
		);
	}

	/**
	 * Enqueue the show scripts.
	 *
	 * @return void
	 */
	public function showScripts() {
		if ( ! empty( $this->scripts['show'] ) ) {
			$this->enqueue( $this->scripts['show'][0], $this->scripts['show'][1] );
		}
	}

	/**
	 * Enqueue a script.
	 *
	 * @param string $handle Script handle.
	 * @param string $path  Path to script.
	 * @param array  $deps Dependencies.
	 *
	 * @return void
	 */
	public function enqueue( $handle, $path, $deps = [] ) {
		$deps = array_merge( $deps, $this->dependencies );
		$deps = array_merge( $deps, [ 'sc-ui-data', 'wp-data', 'wp-core-data' ] );

		wp_enqueue_media();
		wp_enqueue_style( 'wp-components' );
		wp_enqueue_style( 'wp-block-editor' );
		wp_enqueue_style( 'surecart-themes-default' );
		wp_enqueue_script( 'surecart-components' );
		wp_enqueue_script( 'wp-format-library' );
		wp_enqueue_style( 'wp-format-library' );

		// automatically load dependencies and version.
		$asset_file = include plugin_dir_path( SURECART_PLUGIN_FILE ) . "dist/$path.asset.php";

		// Enqueue scripts.
		wp_enqueue_script(
			$handle,
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . "dist/$path.js",
			array_merge( $asset_file['dependencies'], $deps ),
			$asset_file['version'],
			true
		);

		wp_set_script_translations( $handle, 'surecart' );

		wp_localize_script(
			$handle,
			'scData',
			[
				'supported_currencies' => Currency::getSupportedCurrencies(),
				'app_url'              => defined( 'SURECART_APP_URL' ) ? untrailingslashit( SURECART_APP_URL ) : 'https://app.surecart.com',
				'account_id'           => \SureCart::account()->id,
				'account_slug'         => \SureCart::account()->slug,
				'api_url'              => \SureCart::requests()->getBaseUrl(),
				'currency'             => \SureCart::account()->currency,
				'time_zones'           => TimeDate::timezoneOptions(),
				'entitlements'         => \SureCart::account()->entitlements,
				'brand_color'          => \SureCart::account()->brand->color ?? null,
				'plan_name'            => \SureCart::account()->plan->name ?? '',
				'processors'           => Processor::get(),
				'is_block_theme'       => (bool) wp_is_block_theme(),
				'claim_url'            => ! \SureCart::account()->claimed ? \SureCart::routeUrl( 'account.claim' ) : '',
			]
		);
	}
}
