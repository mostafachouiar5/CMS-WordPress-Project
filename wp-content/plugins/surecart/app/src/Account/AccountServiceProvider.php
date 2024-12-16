<?php

namespace SureCart\Account;

use SureCart\Support\Server;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide users dependencies.
 */
class AccountServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.account'] = function () {
			return new AccountService( new Server( get_site_url() ) );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'account', 'surecart.account' );
	}

	/**
	 * Bootstrap
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		if ( ! empty( $container['surecart.account'] ) ) {
			$container['surecart.account']->bootstrap();
		}
	}
}
