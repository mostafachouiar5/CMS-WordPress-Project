<?php

namespace SureCart\Models;

use SureCart\Support\Encryption;

/**
 * Webhook Model.
 */
class WebhookRegistration {
	/**
	 * Registered Webhook option name.
	 *
	 * @var string
	 */
	public const REGISTERED_WEBHOOK_KEY = 'surecart_registered_webhook';

	/**
	 * Deprecated Registered Webhook option name.
	 *
	 * @var string
	 */
	public const DEPRECATED_WEBHOOK_KEY = 'ce_registered_webhook';

	/**
	 * Save the registered webhook.
	 *
	 * @param array $webhook The webhook to save.
	 *
	 * @return bool
	 */
	public function save( $webhook ): bool {
		return update_option(
			self::REGISTERED_WEBHOOK_KEY,
			Encryption::encrypt(
				json_encode(
					[
						'id'             => $webhook['id'],
						'url'            => $webhook['url'],
						'webhook_events' => $webhook['webhook_events'] ?? [],
						'signing_secret' => $webhook['signing_secret'],
					]
				)
			)
		);
	}

	/**
	 * Get registered webhook.
	 *
	 * @return array|null
	 */
	public function get() {
		$webhook = json_decode( Encryption::decrypt( (string) get_option( self::REGISTERED_WEBHOOK_KEY, '' ) ), true );
		if ( empty( $webhook['signing_secret'] ) ) {
			return null;
		}
		$webhook['signing_secret'] = $webhook['signing_secret'];
		return new Webhook( $webhook );
	}

	/**
	 * Delete the registered webhook.
	 *
	 * @return boolean
	 */
	public function delete(): bool {
		return delete_option( self::REGISTERED_WEBHOOK_KEY );
	}
}
