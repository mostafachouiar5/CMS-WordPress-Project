<?php
namespace SureCart\Integrations\LearnDash;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Handles the learnDash Service.
 */
class LearnDashServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.learndash.sync'] = function () {
			return new LearnDashService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.learndash.sync']->bootstrap();
	}
}
