<?php

namespace SureCart\Controllers\Web;

use SureCart\Models\IncomingWebhook;
use SureCart\Models\RegisteredWebhook;
use SureCartVendors\Psr\Http\Message\ResponseInterface;

/**
 * Handles webhooks
 */
class WebhookController {
	/**
	 * Create new webhook for this site.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return ResponseInterface
	 */
	public function create( $request ) {
		// We'll create a webhook for this site register the webhooks.
		$registered = RegisteredWebhook::create();

		// handle error and show notice to user.
		if ( is_wp_error( $registered ) ) {
			// show notice.
			\SureCart::notices()->add(
				[
					'name'  => 'webhooks_registration_error',
					'type'  => 'warning',
					'title' => esc_html__( 'SureCart Webhook Creation Error', 'surecart' ),
					'text'  => sprintf( '<p>%s</p>', ( implode( '<br />', $registered->get_error_messages() ?? [] ) ) ),
				]
			);
		}

		// test it.
		$registered->test();

		return \SureCart::redirect()->to( esc_url_raw( admin_url( 'admin.php?page=sc-dashboard' ) ) );
	}

	/**
	 * Update the webhook.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return ResponseInterface
	 */
	public function update( $request ) {
		// Find the registered webhook.
		$webhook = RegisteredWebhook::find();
		if ( is_wp_error( $webhook ) ) {
			wp_die( wp_kses_post( $webhook->get_error_message() ) );
		}

		// update webhook.
		$updated = RegisteredWebhook::update();

		// handle error.
		if ( is_wp_error( $updated ) ) {
			wp_die( wp_kses_post( $updated->get_error_message() ) );
		}

		return \SureCart::redirect()->to( esc_url_raw( admin_url( 'admin.php?page=sc-dashboard' ) ) );
	}

	/**
	 * This deletes and recreates the webhook
	 * in case the signing secret is invalid for some reason.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return ResponseInterface
	 */
	public function resync( $request ) {
		// Delete the registered webhook.
		$webhook = RegisteredWebhook::registration()->delete();
		if ( is_wp_error( $webhook ) ) {
			wp_die( wp_kses_post( $webhook->get_error_message() ) );
		}

		// recreate.
		return $this->create( $request );
	}

	/**
	 * Recieve webhook.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return ResponseInterface
	 */
	public function receive( $request ) {
		// get json if sent.
		if ( 'application/json' === $request->getHeaderLine( 'Content-Type' ) ) {
			$body = json_decode( $request->getBody(), true );
		} else {
			$body = $request->getParsedBody();
		}

		// validate body.
		if ( empty( $body['type'] ) ) {
			return new \WP_Error( 'missing_type', 'Missing type.' );
		}
		if ( empty( $body['data'] ) ) {
			return new \WP_Error( 'missing_data', 'Missing data.' );
		}
		if ( empty( $body['id'] ) ) {
			return new \WP_Error( 'missing_id', 'Missing id.' );
		}

		// make sure we don't have a duplicate webhook.
		$webhook = IncomingWebhook::where( 'webhook_id', $body['id'] )->first();
		if ( ! empty( $webhook->id ) ) {
			return \SureCart::json(
				[
					'status' => 'already_handled',
				]
			)
			->withHeader( 'X-SURECART-WP-PLUGIN-VERSION', \SureCart::plugin()->version() )
			->withStatus( 200 );
		}

		// create incoming webhook.
		$incoming = IncomingWebhook::create(
			[
				'webhook_id' => $body['id'],
				'data'       => $body,
				'source'     => 'surecart',
			]
		);

		if ( is_wp_error( $incoming ) ) {
			return \SureCart::json(
				[
					'error' => $incoming->get_error_message(),
				]
			)
			->withHeader( 'X-SURECART-WP-PLUGIN-VERSION', \SureCart::plugin()->version() )
			->withStatus( 500 );
		}

		if ( empty( $incoming->id ) ) {
			return \SureCart::json(
				[
					'error' => 'Failed to create webhook.',
				]
			)
			->withHeader( 'X-SURECART-WP-PLUGIN-VERSION', \SureCart::plugin()->version() )
			->withStatus( 400 );
		}

		// dispatch an async request.
		\SureCart::async()->data(
			[
				'id' => $incoming->id,
			]
		)->dispatch();

		// handle the response.
		return $this->handleResponse( $incoming->id, $incoming->toArray() );
	}

	/**
	 * Handle the response back to the webhook.
	 *
	 * @param array|\WP_Error $data Data.
	 * @return function
	 */
	public function handleResponse( $id, $data ) {
		// handle the response.
		if ( is_wp_error( $data ) ) {
			return \SureCart::json( [ $data->get_error_code() => $data->get_error_message() ] )
				->withHeader( 'X-SURECART-WP-PLUGIN-VERSION', \SureCart::plugin()->version() )
				->withStatus( 500 );
		}

		if ( empty( $data ) ) {
			return \SureCart::json( [ 'failed' => true ] )
				->withHeader( 'X-SURECART-WP-PLUGIN-VERSION', \SureCart::plugin()->version() )
				->withStatus( 400 );
		}

		return \SureCart::json(
			[
				'process_id'      => $id,
				'event_triggered' => $data['event'] ?? 'none',
				'data'            => $data,
			]
		)
		->withHeader( 'X-SURECART-WP-PLUGIN-VERSION', \SureCart::plugin()->version() )
		->withStatus( 200 );
	}
}
