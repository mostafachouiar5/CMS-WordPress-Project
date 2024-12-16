<?php
namespace SureCart\Install;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

class InstallServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.install'] = function () {
			return new InstallService();
		};
	}


	/**
	 * Bootstrap any services if needed.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		$container['surecart.users']->register_rest_queries();
	}
}
