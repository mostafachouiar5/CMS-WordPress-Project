<?php

namespace SureCart\WordPress\CLI;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register and enqueues assets.
 */
class CLIServiceProvider implements ServiceProviderInterface {
	/**
	 * Holds the service container
	 *
	 * @var \Pimple\Container
	 */
	protected $container;

	/**
	 * Register all dependencies in the container.
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$container['surecart.cli'] = function () {
			return new CLIService();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];

		$app->alias( 'cli', 'surecart.cli' );
	}

	/**
	 * Bootstrap any services if needed.
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$this->container = $container;
		$container['surecart.cli']->bootstrap();
	}
}
