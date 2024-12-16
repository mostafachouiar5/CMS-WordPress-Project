<?php

namespace SureCart\Webhooks;

use SureCart\Models\RegisteredWebhook;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * WordPress Users service.
 */
class WebhooksServiceProvider implements ServiceProviderInterface {
	/**
	 * Register all dependencies in the IoC container.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function register( $container ) {
		$container['surecart.webhooks'] = function () {
			return new WebhooksService( new RegisteredWebhook() );
		};

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'webhooks', 'surecart.webhooks' );
	}

	/**
	 * Bootstrap any services if needed.
	 *
	 * @param \Pimple\Container $container Service container.
	 * @return void
	 */
	public function bootstrap( $container ) {
		if ( ! empty( $container['surecart.webhooks'] ) ) {
			$container['surecart.webhooks']->bootstrap();
		}
	}
}
