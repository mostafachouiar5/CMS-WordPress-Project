<?php

namespace SureCart\Settings;

use SureCart\Settings\SettingService;
use SureCart\WordPress\RecaptchaValidationService;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register a session for Flash and OldInput to work with.
 */
class SettingsServiceProvider implements ServiceProviderInterface {
	/**
	 * Register settings service.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$app = $container[ SURECART_APPLICATION_KEY ];

		// Service for registering a setting.
		$container['surecart.settings'] = function () {
			return new SettingService();
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'settings', 'surecart.settings' );
	}


	/**
	 * Bootstrap settings.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		$container['surecart.settings']->bootstrap();
	}
}
