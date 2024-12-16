<?php

namespace SureCart\Models;

use SureCart\Support\URL;

/**
 * Registered Webhook Model.
 */
class RegisteredWebhook extends Webhook {
	/**
	 * Create the registered webhook.
	 * Creates a webhook for the current site and stores it in the WP options table.
	 *
	 * @param array $args Unused.
	 *
	 * @return $this|\WP_Error
	 */
	protected function create( $args = [] ) {
		$webhook = parent::create(
			[
				'description'    => 'WordPress Webhook SureCart',
				'enabled'        => true,
				'destination'    => 'wordpress',
				'url'            => $this->getListenerUrl(),
				'webhook_events' => \SureCart::config()->webhook_events,
			]
		);

		// handle error.
		if ( is_wp_error( $webhook ) ) {
			return $webhook;
		}

		// save with signing secret.
		$this->registration()->save( $webhook );

		// return this.
		return $this;
	}

	/**
	 * Get the registered webhook.
	 *
	 * @return \SureCart\Models\Webhook|\WP_Error;
	 */
	protected function get() {
		$id = $this->registration()->get()['id'] ?? null;
		if ( ! $id ) {
			return false;
		}
		return parent::find( $id );
	}

	/**
	 * Alias for get.
	 *
	 * @param string $id Not used.
	 *
	 * @return \SureCart\Models\Webhook|\WP_Error;
	 */
	protected function find( $id = '' ) {
		return $this->get();
	}

	/**
	 * Update the model.
	 *
	 * @param array $attributes Attributes to update.
	 * @return $this|false
	 */
	protected function update( $attributes = [] ) {
		$id      = $this->registration()->get()['id'] ?? null;
		$webhook = parent::update(
			array_merge(
				[
					'id'             => $id,
					'url'            => $this->getListenerUrl(),
					'webhook_events' => \SureCart::config()->webhook_events,
				],
				$attributes
			)
		);

		if ( is_wp_error( $webhook ) ) {
			return $webhook;
		}

		$this->registration()->save( $webhook );

		return $this;
	}

	/**
	 * Delete the model.
	 *
	 * @return $this|false
	 */
	protected function delete( $id = 0 ) {
		$id = $this->registration()->get()['id'] ?? null;

		if ( ! $id ) {
			return false;
		}

		// delete webhook.
		$webhook = parent::delete( $id );

		if ( is_wp_error( $webhook ) ) {
			return $webhook;
		}

		// delete registration.
		$this->registration()->delete();

		return $this;
	}

	/**
	 * Stores the registrationd webhook data in the WP options table.
	 *
	 * @return \SureCart\Models\WebhookRegistration;
	 */
	protected function registration() {
		return new WebhookRegistration();
	}

	/**
	 * Get the listener url.
	 *
	 * @return string
	 */
	protected function getListenerUrl(): string {
		return get_home_url( null, '/surecart/webhooks', is_ssl() ? 'https' : 'http' );
	}

	/**
	 * Send test webhook.
	 *
	 * @return \SureCart\Models\Webhook
	 */
	protected function test() {
		$id = $this->registration()->get()['id'] ?? null;
		return $this->makeRequest(
			[
				'method' => 'POST',
				'query'  => [],
			],
			$this->endpoint . '/' . $id . '/test',
		);
	}

	/**
	 * Does the current domain match the registered webhook domain?
	 *
	 * @return boolean
	 */
	protected function currentDomainMatches() {
		$webhook = $this->registration()->get();
		if ( empty( $webhook['url'] ) ) {
			return false;
		}
		return untrailingslashit( URL::getSchemeAndHttpHost( $webhook['url'] ) ) === untrailingslashit( URL::getSchemeAndHttpHost( $this->getListenerUrl() ) );
	}

	/**
	 * Get the signing secret.
	 *
	 * @return string
	 */
	protected function getSigningSecret() {
		return $this->registration()->get()->signing_secret;
	}

	/**
	 * Has the webhook a signing secret?
	 */
	protected function hasSigningSecret() {
		return (bool) $this->getSigningSecret();
	}
}
