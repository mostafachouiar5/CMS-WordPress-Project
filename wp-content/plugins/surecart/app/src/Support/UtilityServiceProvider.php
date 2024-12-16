<?php

namespace SureCart\Support;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Templates service provider.
 */
class UtilityServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.utility'] = function( $c ) {
			return new UtilityService( $c );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];

		$app->alias( 'utility', 'surecart.utility' );
	}

	/**
	 * Bootstrap the service.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		// nothing to bootstrap.
	}
}
