<?php

namespace SureCart\Database;

use SureCart\Database\Tables\IncomingWebhook;
use SureCart\Database\Tables\Integrations;
use SureCart\Database\Tables\VariantOptionValues;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * WordPress Users service.
 */
class MigrationsServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		$container['surecart.tables.integrations'] = function () {
			return new Integrations( new Table() );
		};

		$container['surecart.tables.webhooks.incoming'] = function () {
			return new IncomingWebhook( new Table() );
		};

		$container['surecart.tables.variant_option_values'] = function () {
			return new VariantOptionValues( new Table() );
		};

		$container['surecart.migrations.usermeta'] = function () {
			return new UserMetaMigrationsService();
		};

		$container['surecart.migrations.webhook'] = function () {
			return new WebhookMigrationsService();
		};

		$container['surecart.migrations.rewrites'] = function () {
			return new RewriteRulesMigrationService();
		};

		$container['surecart.migrations.product_page'] = function () {
			return new ProductPageMigrationService();
		};
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function bootstrap( $container ) {
		$container['surecart.tables.integrations']->install();
		$container['surecart.tables.webhooks.incoming']->install();
		$container['surecart.tables.variant_option_values']->install();
		$container['surecart.migrations.usermeta']->bootstrap();
		$container['surecart.migrations.webhook']->bootstrap();
		$container['surecart.migrations.rewrites']->bootstrap();
		$container['surecart.migrations.product_page']->bootstrap();
	}
}
