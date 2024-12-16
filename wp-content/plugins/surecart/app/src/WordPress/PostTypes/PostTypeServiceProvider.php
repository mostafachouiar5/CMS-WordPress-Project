<?php

namespace SureCart\WordPress\PostTypes;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register our form post type
 */
class PostTypeServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$container['surecart.forms']                  = function ( $container ) {
			return new FormPostTypeService( $container['surecart.pages'] );
		};
		$container['surecart.cart.post']              = function ( $container ) {
			return new CartPostTypeService( $container['surecart.pages'] );
		};
		$container['surecart.post_types.product']     = function () {
			return new ProductPostTypeService();
		};
		$container['surecart.post_types.upsell_page'] = function () {
			return new ProductUpsellPagePostTypeService();
		};
		$container['surecart.metaboxes']              = function () {
			return new MetaboxService();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'forms', 'surecart.forms' );
		$app->alias( 'cartPost', 'surecart.cart.post' );
		$app->alias( 'productPost', 'surecart.post_types.product' );
		$app->alias( 'metaboxes', 'surecart.metaboxes' );
	}

	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.forms']->bootstrap();
		$container['surecart.cart.post']->bootstrap();
		$container['surecart.post_types.product']->bootstrap();
		$container['surecart.post_types.upsell_page']->bootstrap();
	}
}
