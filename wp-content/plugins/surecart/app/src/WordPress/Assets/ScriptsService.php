<?php

namespace SureCart\WordPress\Assets;

use SureCart\Models\ManualPaymentMethod;
use SureCart\Models\Processor;
use SureCart\Support\Currency;

/**
 * Handles the component theme.
 */
class ScriptsService {
	/**
	 * Holds the service container
	 *
	 * @var \Pimple\Container
	 */
	protected $container;

	/**
	 * Make sure we change the script loader tag for esm loading.
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function __construct( $container ) {
		$this->container = $container;

		// add module to components tag.
		add_filter( 'script_loader_tag', [ $this, 'componentsTag' ], 10, 3 );
	}

	/**
	 * Add module to the components tag
	 *
	 * @param string $tag Tag output.
	 * @param string $handle Script handle.
	 * @param string $source Script source.
	 *
	 * @return string
	 */
	public function componentsTag( $tag, $handle, $source ) {
		if ( 'surecart-components' !== $handle || ! $source ) {
			return $tag;
		}
		// don't use javascript module if we are not using esm loader.
		if ( ! \SureCart::assets()->usesEsmLoader() ) {
			return $tag;
		}

		// make sure our translations do not get stripped.
		$translations = wp_scripts()->print_translations( $handle, false );
		if ( $translations ) {
			$translations = sprintf( "<script%s id='%s-js-translations'>\n%s\n</script>\n", " type='text/javascript'", esc_attr( $handle ), $translations );
		}

		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
		return '<script src="' . esc_url_raw( $source ) . '" type="module"></script>' . $translations;
	}

	/**
	 * Get the claim url.
	 *
	 * @return string
	 */
	public function getAccountClaimUrl() {
		return ! wp_doing_ajax() && is_admin() && ! \SureCart::account()->claimed ? \SureCart::routeUrl( 'account.claim' ) : '';
	}

	/**
	 * Register the component scripts and translations.
	 *
	 * @return void
	 */
	public function register() {
		// should we use the esm loader directly?
		if ( ! is_admin() && \SureCart::assets()->usesEsmLoader() ) {
			wp_register_script(
				'surecart-components',
				trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/components/surecart/surecart.esm.js',
				[ 'wp-i18n', 'regenerator-runtime' ],
				filemtime( trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/components/surecart/surecart.esm.js' ) . '-' . \SureCart::plugin()->version(),
				true
			);
		} else {
			// instead, use a static loader that injects the script at runtime.
			$static_assets = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/components/static-loader.asset.php';
			wp_register_script(
				'surecart-components',
				trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/components/static-loader.js',
				array_merge( [ 'wp-i18n', 'regenerator-runtime' ], $static_assets['dependencies'] ?? [] ),
				$static_assets['version'] . '-' . \SureCart::plugin()->version(),
				true
			);
			wp_localize_script(
				'surecart-components',
				'surecartComponents',
				[
					'url' => trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/components/surecart/surecart.esm.js?ver=' . filemtime( trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/components/surecart/surecart.esm.js' ),
				]
			);
		}

		wp_set_script_translations( 'surecart-components', 'surecart' );

		wp_localize_script(
			'surecart-components',
			'scData',
			apply_filters(
				'surecart-components/scData',  // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores,WordPress.NamingConventions.ValidHookName.NotLowercase
				[
					'cdn_root'             => SURECART_CDN_IMAGE_BASE,
					'root_url'             => esc_url_raw( get_rest_url() ),
					'plugin_url'           => \SureCart::core()->assets()->getUrl(),
					'home_url'             => esc_url_raw( home_url() ),
					'api_url'              => \SureCart::requests()->getBaseUrl(),
					'currency'             => \SureCart::account()->currency,
					'currency_symbol'      => html_entity_decode( Currency::getCurrencySymbol( \SureCart::account()->currency ) ),
					'theme'                => get_option( 'surecart_theme', 'light' ),
					'pages'                => [
						'dashboard' => \SureCart::pages()->url( 'dashboard' ),
						'checkout'  => \SureCart::pages()->url( 'checkout' ),
					],
					'page_id'              => get_the_ID(),
					'nonce'                => ( wp_installing() && ! is_multisite() ) ? '' : wp_create_nonce( 'wp_rest' ),
					'nonce_endpoint'       => admin_url( 'admin-ajax.php?action=sc-rest-nonce' ),
					'recaptcha_site_key'   => \SureCart::settings()->recaptcha()->getSiteKey(),
					'claim_url'            => $this->getAccountClaimUrl(),
					'admin_url'            => trailingslashit( admin_url() ),
					'getting_started_url'  => untrailingslashit( admin_url( 'admin.php?page=sc-getting-started' ) ),
					'user_permissions'     => array(
						'manage_sc_shop_settings' => current_user_can( 'manage_sc_shop_settings' ),
					),
					'is_account_connected' => \SureCart::account()->isConnected(),
				]
			)
		);

		wp_localize_script( 'surecart-components', 'scIcons', [ 'path' => esc_url_raw( plugin_dir_url( SURECART_PLUGIN_FILE ) . 'dist/icon-assets' ) ] );

		// core-data.
		$asset_file                   = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/store/data.asset.php';
		$asset_file['dependencies'][] = 'regenerator-runtime';
		wp_register_script(
			'sc-core-data',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/store/data.js',
			array_merge( [ 'surecart-components' ], $asset_file['dependencies'] ?? [] ),
			$asset_file['version'] . '-' . \SureCart::plugin()->version(),
			true
		);

		// ui.
		$asset_file                   = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/store/ui.asset.php';
		$asset_file['dependencies'][] = 'regenerator-runtime';
		wp_register_script(
			'sc-ui-data',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/store/ui.js',
			array_merge( [ 'surecart-components' ], $asset_file['dependencies'] ?? [] ),
			$asset_file['version'] . '-' . \SureCart::plugin()->version(),
			true
		);

		$this->registerBlocks();

		// regsiter recaptcha.
		wp_register_script( 'surecart-google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . \SureCart::settings()->recaptcha()->getSiteKey(), [], \SureCart::plugin()->version(), true );

		// register stripe if enabled.
		if ( get_option( 'surecart_load_stripe_js', false ) ) {
			wp_enqueue_script( 'surecart-stripe-script', 'https://js.stripe.com/v3', [], \SureCart::plugin()->version(), false );
		}

		// templates.
		$asset_file                   = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/templates/admin.asset.php';
		$asset_file['dependencies'][] = 'regenerator-runtime';
		wp_register_script(
			'surecart-templates-admin',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/templates/admin.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		// admin notices.
		$asset_file = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/styles/webhook-notice.asset.php';
		wp_register_style(
			'surecart-webhook-admin-notices',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/styles/webhook-notice.css',
			$asset_file['dependencies'],
			$asset_file['version']
		);

		wp_register_script(
			'surecart-affiliate-tracking',
			esc_url_raw( untrailingslashit( SURECART_JS_URL ) . '/v1/affiliates' ),
			[],
			'1.1',
			[
				'strategy' => 'defer',
			]
		);

		wp_add_inline_script(
			'surecart-affiliate-tracking',
			'window.SureCartAffiliatesConfig = {
				"publicToken": "' . \SureCart::account()->public_token . '",
				"baseURL":"' . esc_url_raw( untrailingslashit( SURECART_API_URL ) ) . '/v1"
			};',
			'before'
		);
	}

	/**
	 * Enqueue block front scripts.
	 *
	 * @return void
	 */
	public function enqueueFront() {
		// make sure it is registered.
		$this->register();
		// enqueue it.
		wp_enqueue_script( 'surecart-components' );

		// fix shitty jetpack issues key hijacking issues.
		add_filter(
			'wp_head',
			function () {
				wp_dequeue_script( 'wpcom-notes-common' );
				wp_dequeue_script( 'wpcom-notes-admin-bar' );
				wp_dequeue_style( 'wpcom-notes-admin-bar' );
				wp_dequeue_style( 'noticons' );
			},
			200
		);
	}

	/**
	 * Enqueue editor scripts.
	 *
	 * @return void
	 */
	public function enqueueEditor() {
		$this->enqueueBlocks();
		$this->enqueuePageTemplateEditor();
		$this->enqueueProductBlocks();
		$this->enqueueProductCollectionBlocks();
	}

	/**
	 * Enqueue page templates.
	 *
	 * @return void
	 */
	public function enqueuePageTemplateEditor() {
		wp_enqueue_script( 'surecart-templates-admin' );
	}

	/**
	 * We only want these available in FSE.
	 *
	 * @return void
	 */
	public function enqueueProductBlocks() {
		global $pagenow;
		if ( 'site-editor.php' !== $pagenow ) {
			return;
		}

		wp_enqueue_script( 'surecart-product-blocks' );
	}

	/**
	 * We only want these available in FSE.
	 *
	 * @return void
	 */
	public function enqueueProductCollectionBlocks() {
		global $pagenow;
		if ( 'site-editor.php' !== $pagenow ) {
			return;
		}

		wp_enqueue_script( 'surecart-product-collection-blocks' );
	}

	/**
	 * Register block scripts.
	 *
	 * @return void
	 */
	public function registerBlocks() {
		$enabled_payment_processors = is_admin() ? array_values(
			array_filter(
				(array) Processor::get() ?? [],
				function ( $payment_method ) {
					return $payment_method->enabled ?? false;
				}
			)
		) : [];
		// blocks.
		$asset_file = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/blocks/library.asset.php';
		$deps       = $asset_file['dependencies'] ?? [];
		// fix bug in deps array.
		$deps[ array_search( 'wp-blockEditor', $deps ) ] = 'wp-block-editor';
		wp_register_script(
			'surecart-blocks',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/blocks/library.js',
			$deps,
			$asset_file['version'] . '-' . \SureCart::plugin()->version(),
			true
		);

		// only register.
		$asset_file = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/blocks/product.asset.php';
		$deps       = $asset_file['dependencies'] ?? [];
		// fix bug in deps array.
		$deps[ array_search( 'wp-blockEditor', $deps ) ] = 'wp-block-editor';
		wp_register_script(
			'surecart-product-blocks',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/blocks/product.js',
			$deps,
			$asset_file['version'],
			true
		);

		// Register product collection blocks.
		$asset_file = include trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/blocks/product_collection.asset.php';
		$deps       = $asset_file['dependencies'] ?? [];
		$deps[ array_search( 'wp-blockEditor', $deps ) ] = 'wp-block-editor';
		wp_register_script(
			'surecart-product-collection-blocks',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/blocks/product_collection.js',
			$deps,
			$asset_file['version'],
			true
		);

		// localize.
		wp_localize_script(
			'surecart-blocks',
			'scData',
			apply_filters(
				'surecart-components/scData', // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores,WordPress.NamingConventions.ValidHookName.NotLowercase
				[
					'root_url'             => esc_url_raw( get_rest_url() ),
					'plugin_url'           => \SureCart::core()->assets()->getUrl(),
					'api_url'              => \SureCart::requests()->getBaseUrl(),
					'currency'             => \SureCart::account()->currency,
					'currency_symbol'      => html_entity_decode( Currency::getCurrencySymbol( \SureCart::account()->currency ) ),
					'theme'                => get_option( 'surecart_theme', 'light' ),
					'pages'                => [
						'dashboard' => \SureCart::pages()->url( 'dashboard' ),
						'checkout'  => \SureCart::pages()->url( 'checkout' ),
					],
					'default_checkout_id'  => (int) \SureCart::forms()->getDefaultId(),
					'page_id'              => get_the_ID(),
					'nonce'                => ( wp_installing() && ! is_multisite() ) ? '' : wp_create_nonce( 'wp_rest' ),
					'nonce_endpoint'       => admin_url( 'admin-ajax.php?action=sc-rest-nonce' ),
					'recaptcha_site_key'   => \SureCart::settings()->recaptcha()->getSiteKey(),
					'claim_url'            => $this->getAccountClaimUrl(),
					'admin_url'            => trailingslashit( admin_url() ),
					'getting_started_url'  => untrailingslashit( admin_url( 'admin.php?page=sc-getting-started' ) ),
					'user_permissions'     => array(
						'manage_sc_shop_settings' => current_user_can( 'manage_sc_shop_settings' ),
					),
					'is_account_connected' => \SureCart::account()->isConnected(),
				]
			)
		);

		wp_localize_script(
			'surecart-blocks',
			'scBlockData',
			[
				'root_url'             => esc_url_raw( get_rest_url() ),
				'nonce'                => ( wp_installing() && ! is_multisite() ) ? '' : wp_create_nonce( 'wp_rest' ),
				'nonce_endpoint'       => admin_url( 'admin-ajax.php?action=sc-rest-nonce' ),
				'processors'           => $enabled_payment_processors,
				'manualPaymentMethods' => is_admin() ? ( (array) ManualPaymentMethod::get() ?? [] ) : [],
				'plugin_url'           => \SureCart::core()->assets()->getUrl(),
				'currency'             => \SureCart::account()->currency,
				'theme'                => get_option( 'surecart_theme', 'light' ),
				'entitlements'         => \SureCart::account()->entitlements,
				'upgrade_url'          => \SureCart::config()->links->purchase,
				'beta'                 => [
					'stripe_payment_element' => (bool) get_option( 'sc_stripe_payment_element', true ),
				],
				'pages'                => [
					'dashboard' => \SureCart::pages()->url( 'dashboard' ),
					'checkout'  => \SureCart::pages()->url( 'checkout' ),
				],
			]
		);

		wp_localize_script( 'surecart-blocks', 'scIcons', [ 'path' => esc_url_raw( plugin_dir_url( SURECART_PLUGIN_FILE ) . 'dist/icon-assets' ) ] );
	}

	/**
	 * Enqueue blocks scripts.
	 *
	 * @return void
	 */
	public function enqueueBlocks() {
		wp_enqueue_script( 'surecart-blocks' );
	}
}
