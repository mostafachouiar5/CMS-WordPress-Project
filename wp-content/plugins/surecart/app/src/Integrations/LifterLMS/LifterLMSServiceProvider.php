<?php

namespace SureCart\Integrations\LifterLMS;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Handles the LifterLMS Service.
 */
class LifterLMSServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.lifterlms'] = function () {
			return new LifterLMSService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.lifterlms']->bootstrap();
	}
}
