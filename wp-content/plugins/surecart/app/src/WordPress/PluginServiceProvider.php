<?php

namespace SureCart\WordPress;

use SureCart\WordPress\PluginService;
use SureCart\WordPress\UpgradeNoticeService;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register plugin options.
 */
class PluginServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.plugin'] = function ( $c ) {
			return new PluginService( $c[ SURECART_APPLICATION_KEY ] );
		};

		$container['surecart.upgrade.notice'] = function ( $c ) {
			return new UpgradeNoticeService( $c[ SURECART_APPLICATION_KEY ] );
		};

		$container['surecart.actions'] = function () {
			return new ActionsService();
		};

		$container['surecart.config.setting'] = function ( $c ) {
			return json_decode( json_encode( $c[ SURECART_CONFIG_KEY ] ) );
		};

		$container['surecart.health'] = function () {
			return new HealthService();
		};

		$container['surecart.compatibility'] = function () {
			return new CompatibilityService();
		};

		$singleton                          = new StateService( [] );
		$container['surecart.initialstate'] = function () use ( $singleton ) {
			return $singleton;
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'plugin', 'surecart.plugin' );
		$app->alias( 'actions', 'surecart.actions' );
		$app->alias( 'config', 'surecart.config.setting' );
		$app->alias( 'healthCheck', 'surecart.health' );
		$app->alias( 'state', 'surecart.initialstate' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		$container['surecart.health']->bootstrap();
		$container['surecart.compatibility']->bootstrap();
		$container['surecart.initialstate']->bootstrap();
		$container['surecart.upgrade.notice']->bootstrap();
	}

	/**
	 * Load textdomain.
	 *
	 * @return void
	 */
	public function loadTextdomain() {
		load_plugin_textdomain( 'surecart', false, basename( dirname( SURECART_PLUGIN_FILE ) ) . DIRECTORY_SEPARATOR . 'languages' );
	}
}
