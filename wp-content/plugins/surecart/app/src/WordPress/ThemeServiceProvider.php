<?php

namespace SureCart\WordPress;

use SureCartCore\ServiceProviders\ServiceProviderInterface;
use SureCart\Models\Form;

/**
 * Register translations.
 */
class ThemeServiceProvider implements ServiceProviderInterface {

	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.theme'] = function() {
			return new ThemeService();
		};
	}

	/**
	 * Bootstrap the service.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		$container['surecart.theme']->bootstrap();
	}
}
