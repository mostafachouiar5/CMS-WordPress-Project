<?php
namespace SureCart\Integrations\User;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Handles the User Service.
 */
class UserServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.integrations.user'] = function () {
			return new UserService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.integrations.user']->bootstrap();
	}
}
