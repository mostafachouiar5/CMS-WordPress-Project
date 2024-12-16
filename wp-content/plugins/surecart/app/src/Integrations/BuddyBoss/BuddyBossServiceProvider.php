<?php

namespace SureCart\Integrations\BuddyBoss;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Handles the BuddyBoss Service.
 */
class BuddyBossServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.buddyboss.platform'] = function () {
			return new BuddyBossService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.buddyboss.platform']->bootstrap();
	}
}
