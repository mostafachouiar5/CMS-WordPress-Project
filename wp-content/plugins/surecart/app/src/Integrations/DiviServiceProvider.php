<?php
namespace SureCart\Integrations;

use SureCart\Migration\ProductPageWrapperService;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Divi Service Provider
 */
class DiviServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		add_filter( 'surecart/shortcode/render', [ $this, 'handleDiviShortcode' ], 10, 4 );
		add_filter( 'et_builder_render_layout', [ $this,'handleProductPageWrapper' ], 12 );
	}

	/**
	 * If divi is active, only load the assets on the current request.
	 *
	 * @param string $content Content of Shortcode.
	 * @param string $atts Attributes of Shortcode.
	 * @param string $atts Shortcode Tag.
	 * @param string $form Form Object if present.
	 *
	 * @return string $content Content of Shortcode || The Shortcode itself.
	 */
	public function handleDiviShortcode( $content, $atts, $name, $form = false ) {

		if ( 'sc_form' !== $name || empty( $atts['id'] ) || empty( $_GET['et_pb_preview'] ) ) {
			return $content;
		}

		return '[sc_form id="' . $atts['id'] . '"]';
	}

	/**
	 * Handle product page wrapper
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function handleProductPageWrapper( $content ) {
		$original_post = get_post();
		global $post;
		$post = get_queried_object(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post );

		$output = ( new ProductPageWrapperService( $content ) )->wrap();

		$post = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $original_post );

		return $output;
	}
}
