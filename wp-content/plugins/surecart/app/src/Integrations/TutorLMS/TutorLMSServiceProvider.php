<?php
namespace SureCart\Integrations\TutorLMS;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Handles the learnDash Service.
 */
class TutorLMSServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.integrations.tutor'] = function () {
			return new TutorLMSService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.integrations.tutor']->bootstrap();
	}
}
