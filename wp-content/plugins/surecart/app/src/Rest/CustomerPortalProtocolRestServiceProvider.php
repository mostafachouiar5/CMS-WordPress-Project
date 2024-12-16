<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\CustomerPortalProtocolController;
use SureCart\Models\User;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class CustomerPortalProtocolRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'customer_portal_protocol';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = CustomerPortalProtocolController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [];

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			"$this->endpoint",
			array_filter(
				[
					[
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => $this->callback( $this->controller, 'find' ),
						'permission_callback' => [ $this, 'get_item_permissions_check' ],
						'args'                => $this->get_collection_params(),
					],
					[
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => $this->callback( $this->controller, 'edit' ),
						'permission_callback' => [ $this, 'update_item_permissions_check' ],
					],
					'schema' => [ $this, 'get_item_schema' ],
				]
			)
		);
	}

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
				'id'                                    => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
				'created_at'                            => [
					'type'    => 'integer',
					'context' => [ 'edit' ],
				],
				'updated_at'                            => [
					'type'    => 'integer',
					'context' => [ 'edit' ],
				],
				'subscription_cancellations_enabled'    => [
					'description' => esc_html__( 'Whether or not customers can cancel subscriptions from the customer portal.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'subscription_updates_enabled'          => [
					'description' => esc_html__( 'Whether or not customers can make subscription changes from the customer portal.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'subscription_quantity_updates_enabled' => [
					'description' => esc_html__( 'Whether or not customers can change subscription quantities from the customer portal.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'terms_url'                             => [
					'description' => esc_html__( 'The terms of service link that is shown to customers on the customer portal.', 'surecart' ),
					'type'        => 'string',
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Anyone can get the protocols.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		if ( current_user_can( 'read_sc_subscriptions', $request->get_params() ) ) {
			return true;
		}
		// user must be a customer to get the protocols.
		return is_user_logged_in() && User::current()->isCustomer();
	}

	/**
	 * Need priveleges to update.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_subscriptions' );
	}
}
