<?php

namespace SureCart\Support\Errors;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

class ErrorsServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$app = $container[ SURECART_APPLICATION_KEY ];

		$container['checkout.errors_service'] = function () {
			return new ErrorsService();
		};

		$app->alias( 'errors', 'checkout.errors_service' );
	}

	/**
	 * {@inheritDoc}
	 *
	 *  @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
