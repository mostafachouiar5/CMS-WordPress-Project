<?php
namespace SureCart\Integrations\ThriveAutomator;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provides the Thrive Automator service.
 */
class ThriveAutomatorServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.thrive.automator'] = function () {
			return new ThriveAutomatorService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		add_action( 'thrive_automator_init', [ $container['surecart.thrive.automator'], 'bootstrap' ] );
	}
}
