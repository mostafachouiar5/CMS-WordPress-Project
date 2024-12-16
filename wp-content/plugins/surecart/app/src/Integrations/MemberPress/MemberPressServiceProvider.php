<?php
namespace SureCart\Integrations\MemberPress;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Handles the learnDash Service.
 */
class MemberPressServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.memberpress'] = function () {
			return new MemberPressService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.memberpress']->bootstrap();
	}
}
