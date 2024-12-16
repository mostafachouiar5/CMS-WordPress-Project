<?php

namespace SureCart\Webhooks;

use SureCart\Models\ApiToken;
use SureCart\Models\IncomingWebhook;
use SureCart\Support\Encryption;
use SureCart\Support\Server;
use SureCart\Support\URL;

/**
 * Webhooks service.
 */
class WebhooksService {
	/**
	 * The registered webhook.
	 *
	 * @var \SureCart\Models\RegisteredWebhook
	 */
	protected $webhook;

	/**
	 * Get the registered webhook.
	 *
	 * @param \SureCart\Models\RegisteredWebhook $webhook The registered webhook.
	 */
	public function __construct( \SureCart\Models\RegisteredWebhook $webhook ) {
		$this->webhook = $webhook;
	}

	/**
	 * Bootstrap the integration.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// delete any old webhook processes.
		add_action( 'delete_expired_transients', [ $this, 'deleteOldWebhookProcesses' ] );
		// we can skip this for localhost or non-secure connections.
		if ( apply_filters( 'surecart/webhooks/localhost/register', $this->isLocalHost() ) || ! is_ssl() ) {
			return;
		}
		// maybe create webhooks if they are not yet created.
		\add_action( 'admin_init', [ $this, 'maybeCreate' ] );
		// listen for any domain changes and show notice.
		\add_action( 'admin_notices', [ $this, 'maybeShowDomainChangeNotice' ] );
		// verify existing webhooks are functioning properly.
		// \add_action( 'admin_init', [ $this, 'verify' ] );
	}

	/**
	 * Delete any webhook processes older than 30 days.
	 *
	 * @return void
	 */
	public function deleteOldWebhookProcesses() {
		IncomingWebhook::deleteExpired( apply_filters( 'surecart/webhook/processes/log_expiration', '30 days' ) );
	}

	/**
	 * Maybe show a notice to the user that the domain has changed.
	 *
	 * This will prompt them to take action to either update the webhook or create a new webhook.
	 *
	 * @return string|null
	 */
	public function maybeShowDomainChangeNotice() {
		$webhook = $this->webhook->get();

		// let's handle the error elsewhere.
		if ( is_wp_error( $webhook ) || empty( $webhook['id'] ) || empty( $webhook['url'] ) ) {
			return;
		}

		// the domain matches, so everything is good.
		if ( $this->webhook->currentDomainMatches() ) {
			return;
		}

		// if domain does not match, then show notice.
		wp_enqueue_style( 'surecart-webhook-admin-notices' );
		return \SureCart::render(
			'admin/notices/webhook-change',
			[
				'previous_webhook' => $webhook,
				'update_url'       => esc_url( \SureCart::getUrl()->editModel( 'update_webhook', $webhook['id'] ) ),
				'add_url'          => esc_url( \SureCart::getUrl()->editModel( 'create_webhook', '0' ) ),
				'previous_web_url' => esc_url_raw( URL::getSchemeAndHttpHost( $webhook['url'] ) ),
				'current_web_url'  => esc_url_raw( URL::getSchemeAndHttpHost( $this->webhook->getListenerUrl() ) ),
			]
		);
	}

	/**
	 * Do we have a token.
	 *
	 * @return boolean
	 */
	public function hasToken(): bool {
		return ! empty( ApiToken::get() );
	}

	/**
	 * May be Create webhooks for this site.
	 *
	 * @return void
	 */
	public function maybeCreate(): void {
		// Check for API key and early return if not.
		if ( ! $this->hasToken() ) {
			return;
		}

		// get the saved webhook.
		$registered = $this->webhook->get();

		// We have one registered already.
		if ( ! empty( $registered->id ) ) {
			return;
		}

		// register the webhooks.
		$registered = $this->webhook->create();

		// handle error and show notice to user.
		if ( is_wp_error( $registered ) ) {
			\SureCart::notices()->add(
				[
					'name'  => 'webhooks_registration_error',
					'type'  => 'warning',
					'title' => esc_html__( 'SureCart Webhook Registration Error', 'surecart' ),
					'text'  => sprintf( '<p>%s</p>', ( implode( '<br />', $registered->get_error_messages() ?? [] ) ) ),
				]
			);
			return;
		}

		// send a test.
		$registered->test();
	}

	/**
	 * Is this localhost?
	 *
	 * @return boolean
	 */
	public function isLocalHost() {
		return ( new Server( $this->webhook->getListenerUrl() ) )->isLocalHost();
	}

	/**
	 * Verify webhooks.
	 *
	 * @return function
	 */
	// public function verify() {
	// $webhook = $this->webhook->get();

	// if ( is_wp_error( $webhook ) ) {
	// not found, let's recreate one.
	// if ( 'webhook_endpoint.not_found' === $webhook->get_error_code() ) {
	// delete saved.
	// $this->webhook->registration()->delete();
	// create.
	// return $this->maybeCreate();
	// }

	// handle other errors.
	// return \SureCart::notices()->add(
	// [
	// 'name'  => 'webhooks_general_error',
	// 'type'  => 'error',
	// 'title' => esc_html__( 'SureCart Webhooks Error', 'surecart' ),
	// 'text'  => sprintf( '<p>%s</p>', ( implode( '<br />', $webhook->get_error_messages() ?? [] ) ) ),
	// ]
	// );
	// }

	// If webhook is not created, show notice.
	// This should not happen, but just in case.
	// if ( ! $webhook || empty( $webhook->id ) ) {
	// return \SureCart::notices()->add(
	// [
	// 'name'  => 'webhooks_not_created',
	// 'type'  => 'error',
	// 'title' => esc_html__( 'SureCart Webhooks Error', 'surecart' ),
	// 'text'  => '<p>' . esc_html__( 'Webhooks cannot be created.', 'surecart' ) . '</p>',
	// ]
	// );
	// }

	// Show the grace period notice.
	// if ( ! empty( $webhook->erroring_grace_period_ends_at ) ) {
	// $message   = [];
	// $message[] = $webhook->erroring_grace_period_ends_at > time() ? esc_html__( 'Your SureCart webhook connection is being monitored due to errors. This can cause issues with any of your SureCart integrations.', 'surecart' ) : esc_html__( 'Your SureCart webhook connection was disabled due to repeated errors. This can cause issues with any of your SureCart integrations.', 'surecart' );
	// $message[] = $webhook->erroring_grace_period_ends_at > time() ? sprintf( wp_kses( 'These errors will automatically attempt to be retried, however, we will disable this in <strong>%s</strong> if it continues to fail.', 'surecart' ), human_time_diff( $webhook->erroring_grace_period_ends_at ) ) : sprintf( wp_kses( 'It was automatically disabled %s ago.', 'surecart' ), human_time_diff( $webhook->erroring_grace_period_ends_at ) );
	// $message[] = __( 'If you have already fixed this you can dismiss this notice.', 'surecart' );
	// $message[] = '<p>
	// <a href="' . esc_url( \SureCart::getUrl()->editModel( 'resync_webhook', $webhook['id'] ) ) . '" class="button">' . esc_html__( 'Resync Webhook', 'surecart' ) . '</a>
	// &nbsp;<a href="' . esc_url( untrailingslashit( SURECART_APP_URL ) . '/developer' ) . '" target="_blank">' . esc_html__( 'Troubleshoot Connection', 'surecart' ) . '</a>
	// </p>';

	// return \SureCart::notices()->add(
	// [
	// 'name'  => 'webhooks_erroring_grace_period_' . $webhook->erroring_grace_period_ends_at,
	// 'type'  => 'warning',
	// 'title' => esc_html__( 'SureCart Webhook Connection', 'surecart' ),
	// 'text'  => sprintf( '<p>%s</p>', ( implode( '<br />', $message ) ) ),
	// ]
	// );
	// }
	// }

	/**
	 * Get the signing secret stored as encrypted data in the WP database.
	 *
	 * @return string|bool Decrypted value, or false on failure.
	 */
	public function getSigningSecret() {
		// Get the registered webhook.
		$webhook = $this->webhook->get();
		// Return the signing secret from the registered webhook.
		return Encryption::decrypt( $webhook['signing_secret'] ?? '' );
	}
}
