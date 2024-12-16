<?php
namespace SureCart\Controllers\Rest;

use SureCart\Models\RegisteredWebhook;

/**
 * Handles webhooks
 */
class RegisteredWebhookController extends RestController {

	/**
	 * Get the webhook.
	 *
	 * @param \WP_REST_Request $request Request.
	 * @return \WP_REST_Response
	 */
	public function index( $request ) {
		return RegisteredWebhook::find();
	}

	/**
	 * Resync the webhook.
	 *
	 * @param \WP_REST_Request $request Request.
	 * @return \WP_REST_Response
	 */
	public function resync( $request ) {
		// Delete the registered webhook.
		$webhook = RegisteredWebhook::registration()->delete();
		if ( is_wp_error( $webhook ) ) {
			return $webhook;
		}

		// created.
		$created = RegisteredWebhook::create();
		if ( is_wp_error( $created ) ) {
			return $created;
		}

		// test it.
		$created->test();

		// return it.
		return $created;
	}
}
