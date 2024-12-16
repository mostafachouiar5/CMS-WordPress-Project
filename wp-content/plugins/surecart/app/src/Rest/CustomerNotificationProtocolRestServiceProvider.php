<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\CustomerNotificationProtocolController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class CustomerNotificationProtocolRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'customer_notification_protocol';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = CustomerNotificationProtocolController::class;

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
				'id'                      => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
				'created_at'              => [
					'type'    => 'integer',
					'context' => [ 'edit' ],
				],
				'updated_at'              => [
					'type'    => 'integer',
					'context' => [ 'edit' ],
				],
				'abandoned_order_enabled' => [
					'description' => esc_html__( 'If set to true abandonded order reminder emails will be sent to customers.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'order_enabled'           => [
					'description' => esc_html__( 'If set to true order confirmation emails will be sent to customers.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'payment_failure_enabled' => [
					'description' => esc_html__( 'If set to true subscription dunning emails will be sent to customers.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'refund_enabled'          => [
					'description' => esc_html__( 'If set to true refund emails will be sent to customers.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
				],
				'from_name'               => [
					'description' => esc_html__( 'The from name to use when sending emails to customers.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'locale'                  => [
					'description' => esc_html__( 'The language that will be used for all customer notifications. Current available locales are de, en, es, and fr.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'reply_to_email'          => [
					'description' => esc_html__( 'The reply-to email address to use when sending emails to customers.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
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
		return current_user_can( 'manage_options' );
	}

	/**
	 * Need priveleges to update.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'manage_options' );
	}
}
