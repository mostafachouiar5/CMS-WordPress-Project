<?php
namespace SureCart\Integrations\Beaver;

use SureCart\Migration\ProductPageWrapperService;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Beaver service provider.
 */
class BeaverServiceProvider implements ServiceProviderInterface {

	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		// nothing to register.
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		if ( ! class_exists( 'FLBuilderLoader' ) ) {
			return;
		}
		add_action( 'init', [ $this, 'module' ] );
		add_action( 'wp_ajax_surecart_fetch_forms', [ $this, 'fetch_forms' ] );
		add_action( 'fl_builder_after_render_shortcodes', [ $this, 'handle_product_page_wrapper' ] );
	}

	/**
	 * Beaver load scripts
	 *
	 * @return void
	 */
	public function fetch_forms() {
		// Verify nonce.
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wp_rest' ) ) {
			wp_send_json_error();
		}

		// Need to edit posts.
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error();
		}

		$args = [
			'numberposts' => -1,
			'fields'      => 'ids',
		];

		if ( ! empty( $_POST['search'] ) ) {
			$args['s'] = sanitize_text_field( $_POST['search'] );
		}

		$get_forms = \SureCart::forms()->get_forms( $args );
		$forms     = [];

		foreach ( $get_forms as $form_id ) {
			$forms[] = [
				'ID'         => $form_id,
				'post_title' => get_the_title( $form_id ),
			];
		}

		wp_send_json_success( $forms );
	}

	/**
	 * Beaver module register
	 *
	 * @return void
	 */
	public function module() {
		if ( ! class_exists( 'FLBuilderLoader' ) ) {
			return;
		}

		define( 'SURECART_BB_DIR', plugin_dir_path( __FILE__ ) );
		define( 'SURECART_BB_URL', plugins_url( '/', __FILE__ ) );
		$beaverModule = new BeaverFormModule();

		\FLBuilder::register_module( BeaverFormModule::class, $beaverModule::getSettings() );
	}

	/**
	 * Handle product page wrapper
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function handle_product_page_wrapper( $content ) {
		return (new ProductPageWrapperService( $content ))->wrap();
	}
}
