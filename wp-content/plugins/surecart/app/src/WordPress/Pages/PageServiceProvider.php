<?php

namespace SureCart\WordPress\Pages;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide users dependencies.
 */
class PageServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.pages'] = function () {
			return new PageService();
		};

		$container['surecart.pages.seeder'] = function ( $container ) {
			return new PageSeeder( $container['surecart.forms'], $container['surecart.pages'] );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'pages', 'surecart.pages' );
		$app->alias( 'page_seeder', 'surecart.pages.seeder' );
	}

	/**
	 * Bootstrap any services if needed.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		$container['surecart.pages']->bootstrap();
	}
}
