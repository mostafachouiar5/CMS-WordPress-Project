<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\AbandonedCheckoutsController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class AbandonedCheckoutRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'abandoned_checkouts';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = AbandonedCheckoutsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find', 'edit' ];

	/**
	 * Get our sample schema for a post.
	 *
	 * @return array The sample schema for a post
	 */
	public function get_item_schema() {
		if ( $this->schema ) {
			// Since WordPress 5.3, the schema can be cached in the $schema property.
			return $this->schema;
		}

		$this->schema = [
			// This tells the spec of JSON Schema we are using which is draft 4.
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			// The title property marks the identity of the resource.
			'title'      => $this->endpoint,
			'type'       => 'object',
			// In JSON Schema you can specify object properties in the properties attribute.
			'properties' => [
				'id'                          => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'notification_status'         => [
					'description' => esc_html__( 'The current notification status for this abandonded checkout, which can be one of not_sent, scheduled, or sent.', 'surecart' ),
					'type'        => 'string',
					'readonly'    => true,
				],
				'notifications_scheduled_at'  => [
					'description' => esc_html__( 'The current status of this abandonded checkout, which can be one of not_notified, notified, or recovered.', 'surecart' ),
					'type'        => 'object',
					'readonly'    => true,
				],
				'checkout'                    => [
					'description' => esc_html__( 'The checkout id for the checkout.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
				'customer'                    => [
					'description' => esc_html__( 'The customer for the checkout.', 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
				'recovered_checkout' => [
					'description' => esc_html__( "This customer's most recent checkout that has been abandoned.", 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Anyone can get a specific order if they have the unique order id.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_checkouts' );
	}

	/**
	 * Listing
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_checkouts' );
	}

	/**
	 * Need priveleges to update.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_checkouts' );
	}
}
