<?php
namespace SureCart\Controllers\Web;

/**
 * Handles Instant Checkout Page.
 */
class BuyPageController extends BasePageController {
	/**
	 * Handle filters.
	 *
	 * @return void
	 */
	public function filters(): void {
		parent::filters();
		// Add edit product link to admin bar.
		add_action( 'admin_bar_menu', [ $this, 'addEditProductLink' ], 99 );
		// add styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );
		// add scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		// add seo meta data.
		add_action( 'wp_head', [ $this, 'addSeoMetaData' ] );
		// add json schema.
		add_action( 'wp_head', [ $this, 'addProductJsonSchema' ] );
	}

	/**
	 * Preload the image above the fold.
	 *
	 * @return void
	 */
	public function preloadImage(): void {
		if ( empty( $this->model->product_medias->data ) || is_wp_error( $this->model->product_medias->data ) ) {
			return;
		}
		$product_media = $this->model->product_medias->data[0];
		?>
		<link rel="preload" fetchpriority="high" as="image" href="<?php echo esc_url( $product_media->getUrl( 450 ) ); ?>">
		<?php
	}

	/**
	 * Add edit links
	 *
	 * @param \WP_Admin_bar $wp_admin_bar The admin bar.
	 *
	 * @return void
	 */
	public function addEditProductLink( $wp_admin_bar ) {
		if ( empty( $this->model->id ) ) {
			return;
		}
		$wp_admin_bar->add_node(
			[
				'id'    => 'edit',
				'title' => __( 'Edit Product', 'surecart' ),
				'href'  => esc_url( \SureCart::getUrl()->edit( 'product', $this->model->id ) ),
			]
		);
	}

	/**
	 * Show the product page
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @param \SureCartCore\View                      $view View.
	 * @param string                                  $id The id of the product.
	 * @return function
	 */
	public function show( $request, $view, $id ) {
		$id = get_query_var( 'sc_checkout_product_id' );

		// fetch the product by id/slug.
		$this->model = \SureCart\Models\Product::with( [ 'image', 'prices', 'product_medias', 'product_media.media', 'variants', 'variant_options' ] )->find( $id );

		if ( is_wp_error( $this->model ) ) {
			return $this->handleError( $this->model );
		}

		// if this buy page is not enabled, check read permissions.
		if ( ! $this->model->buyLink()->isEnabled() && ! current_user_can( 'read_sc_products' ) ) {
			return $this->notFound();
		}

		// slug changed or we are using the id, redirect.
		if ( $this->model->slug !== $id ) {
			return \SureCart::redirect()->to( esc_url_raw( \SureCart::routeUrl( 'product', [ 'id' => $this->model->slug ] ) ) );
		}

		// get active prices.
		$active_prices = $this->model->active_prices;

		// must have at least one active price.
		if ( empty( $active_prices[0] ) ) {
			return $this->notFound();
		}

		// prevent 404 redirects by 3rd party plugins.
		$_SERVER['REQUEST_URI'] = $request->getUrl();

		// add the filters.
		$this->filters();

		// prepare data.
		$this->model              = $this->model->withActivePrices()->withSortedPrices();
		$first_variant_with_stock = $this->model->first_variant_with_stock;

		if ( ! empty( $this->model->prices->data[0]->id ) ) {
			$line_item = array_merge(
				[
					'price_id' => $this->model->prices->data[0]->id,
					'quantity' => 1,
				],
				! empty( $first_variant_with_stock->id ) ? [ 'variant_id' => $first_variant_with_stock->id ] : []
			);
			sc_initial_state(
				[
					'checkout' => [
						'initialLineItems' => sc_initial_line_items( [ $line_item ] ),
					],
				]
			);
		}

		// render the view.
		return \SureCart::view( 'web/buy' )->with(
			[
				'product'          => $this->model,
				'terms_text'       => $this->termsText(),
				'mode'             => $this->model->buyLink()->getMode(),
				'store_name'       => \SureCart::account()->name ?? get_bloginfo(),
				'logo_url'         => \SureCart::account()->brand->logo_url,
				'logo_width'       => \SureCart::settings()->get( 'buy_link_logo_width', '180px' ),
				'user'             => wp_get_current_user(),
				'logout_link'      => wp_logout_url( $request->getUrl() ),
				'dashboard_link'   => \SureCart::pages()->url( 'dashboard' ),
				'enabled'          => $this->model->buyLink()->isEnabled(),
				'show_logo'        => $this->model->buyLink()->templatePartEnabled( 'logo' ),
				'show_terms'       => $this->model->buyLink()->templatePartEnabled( 'terms' ),
				'show_image'       => $this->model->buyLink()->templatePartEnabled( 'image' ),
				'show_description' => $this->model->buyLink()->templatePartEnabled( 'description' ),
				'show_coupon'      => $this->model->buyLink()->templatePartEnabled( 'coupon' ),
				'success_url'      => $this->model->buyLink()->getSuccessUrl(),
			]
		);
	}

	/**
	 * Enqueue styles.
	 *
	 * @return void
	 */
	public function styles() {
		wp_enqueue_style(
			'surecart/instant-checkout',
			trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'dist/templates/instant-checkout.css',
			[],
			filemtime( trailingslashit( plugin_dir_path( SURECART_PLUGIN_FILE ) ) . 'dist/templates/instant-checkout.css' ),
		);

		// add recaptcha if enabled.
		if ( \SureCart::settings()->recaptcha()->isEnabled() ) {
			wp_enqueue_script( 'surecart-google-recaptcha' );
		}
	}

	/**
	 * Generate the terms html.
	 *
	 * @return string
	 */
	public function termsText() {
		$terms_url   = \SureCart::account()->customer_portal_protocol->terms_url;
		$privacy_url = \SureCart::account()->customer_portal_protocol->privacy_url;

		if ( ! empty( $terms_url ) && ! empty( $privacy_url ) ) {
			return sprintf(
				// translators: %1$1s is the store name, %2$2s is the opening anchor tag, %3$3s is the closing anchor tag, %4$4s is the opening anchor tag, %5$5s is the closing anchor tag.
				__( "I agree to %1$1s's %2$2sTerms%3$3s and %4$4sPrivacy Policy%5$5s", 'surecart' ),
				esc_html( \SureCart::account()->name ),
				'<a href="' . esc_url( $terms_url ) . '" target="_blank">',
				'</a>',
				'<a href="' . esc_url( $privacy_url ) . '" target="_blank">',
				'</a>'
			);
		}

		if ( $terms_url ) {
			return sprintf(
				// translators: %1$1s is the store name, %2$2s is the opening anchor tag, %3$3s is the closing anchor tag.
				__( "I agree to %1$1s's %2$2sTerms%3$3s", 'surecart' ),
				esc_html( \SureCart::account()->name ),
				'<a href="' . esc_url( $terms_url ) . '" target="_blank">',
				'</a>'
			);
		}

		if ( $privacy_url ) {
			return sprintf(
				// translators: %1$1s is the store name, %2$2s is the opening anchor tag, %3$3s is the closing anchor tag.
				__( "I agree to %1$1s's %2$2sPrivacy Policy%3$3s", 'surecart' ),
				esc_html( \SureCart::account()->name ),
				'<a href="' . esc_url( $privacy_url ) . '" target="_blank">',
				'</a>'
			);
		}

		return '';
	}

	/**
	 * Add the SEO meta data.
	 *
	 * @return void
	 */
	public function addSeoMetaData(): void {
		$product = $this->model;

		if ( empty( $product ) ) {
			return;
		}

		$display_seo_meta = apply_filters( 'sc_display_instant_checkout_seo_meta', true, $product );
		if ( ! $display_seo_meta ) {
			return;
		}

		// render the seo meta.
		\SureCart::productPost()->renderProductSeoMeta( $product );
	}

	/**
	 * Add the JSON-LD schema for the product.
	 *
	 * @return void
	 */
	public function addProductJsonSchema(): void {
		$product = $this->model;

		if ( empty( $product ) ) {
			return;
		}

		$display_schema = apply_filters( 'sc_display_instant_checkout_json_ld_schema', true, $product );
		if ( ! $display_schema ) {
			return;
		}

		$schema = \SureCart::productPost()->getJsonSchemaArray( $product ) ?? [];
		if ( empty( $schema ) ) {
			return;
		}
		?>
		<script type="application/ld+json"><?php echo wp_json_encode( $schema ); ?></script>
		<?php
	}
}
