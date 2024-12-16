<?php

namespace SureCart\WordPress\Assets;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Register and enqueues assets.
 */
class AssetsServiceProvider implements ServiceProviderInterface {
	/**
	 * Holds the service container
	 *
	 * @var \Pimple\Container
	 */
	protected $container;

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$container['surecart.assets'] = function () use ( $container ) {
			return new AssetsService( new BlockAssetsLoadService(), new ScriptsService( $container ), new StylesService( $container ), $container );
		};

		$container['surecart.assets.preload'] = function() use ( $container ) {
			return new PreloadService( trailingslashit( $container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . 'dist/components/stats.json' );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];

		$app->alias( 'assets', 'surecart.assets' );
		$app->alias( 'preload', 'surecart.assets.preload' );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$this->container = $container;
		$container['surecart.assets']->bootstrap();
		$container['surecart.assets.preload']->bootstrap();
	}
}
