<?php

namespace SureCart\WordPress\Admin\Profile;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register plugin options.
 */
class UserProfileServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.admin.profile'] = function () {
			return new UserProfileService();
		};
	}

	/**
	 * Bootstrap any services if needed.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		$container['surecart.admin.profile']->bootstrap();
	}
}
