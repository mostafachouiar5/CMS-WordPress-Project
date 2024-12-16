<?php

namespace SureCart\Routing;

use SureCart\Routing\AdminRouteService;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide custom route conditions.
 * This is an example class so feel free to modify or remove it.
 */
class AdminRouteServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$container['surecart.admin.route'] = function () {
			return new AdminRouteService();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];

		$app->alias(
			'getUrl',
			function () use ( $container ) {
				return call_user_func_array( [ $container['surecart.admin.route'], 'getUrl' ], func_get_args() );
			}
		);

		$app->alias(
			'getAdminPageNames',
			function () use ( $container ) {
				return call_user_func_array( [ $container['surecart.admin.route'], 'getPageNames' ], func_get_args() );
			}
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// nothing to bootstrap.
	}
}
