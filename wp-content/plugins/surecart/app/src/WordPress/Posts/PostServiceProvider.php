<?php

namespace SureCart\WordPress\Posts;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide users dependencies.
 */
class PostServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.post'] = function () {
			return new PostService();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'post', 'surecart.post' );
	}

	/**
	 * Bootstrap any services if needed.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		// nothing to bootstrap.
	}
}
