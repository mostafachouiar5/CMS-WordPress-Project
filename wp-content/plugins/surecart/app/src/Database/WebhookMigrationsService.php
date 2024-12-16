<?php

namespace SureCart\Database;

use SureCart\Models\RegisteredWebhook;

/**
 * Run this migration when version changes or for new installations.
 */
class WebhookMigrationsService extends VersionMigration {
	/**
	 * The key for the migration.
	 *
	 * @var string
	 */
	protected $migration_key = 'surecart_webhook_migration_version';

	/**
	 * Run the migration.
	 *
	 * @return void
	 */
	public function run(): void {
		error_log( 'webhook' );
		// Get the registered webhooks.
		$webhook = RegisteredWebhook::get();

		// Stop if webhook is not found or there is some sort of error.
		if ( ! $webhook || is_wp_error( $webhook ) || empty( $webhook->id ) || empty( $webhook->url ) ) {
			return;
		}

		// Update the webhook. This will update the events on the server.
		try {
			RegisteredWebhook::update();
		} catch ( \Exception $exception ) {
			wp_die( 'Webhook migration failed. Error: ' . esc_attr( $exception->getMessage() ) );
		}
	}
}
