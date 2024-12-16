<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\ShippingProtocolController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for shipping protocol REST API Requests
 */
class ShippingProtocolRestServiceProvider  extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'shipping_protocol';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ShippingProtocolController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'find', 'edit' ];

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
				'id'               => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'shipping_enabled' => [
					'description' => esc_html__( 'Whether or not shipping is enabled', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'created_at'       => [
					'type'    => 'integer',
					'context' => [ 'view', 'edit', 'embed' ],
				],
				'updated_at'       => [
					'type'    => 'integer',
					'context' => [ 'view', 'edit', 'embed' ],
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Need privileges to get item
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'manage_sc_shop_settings' );
	}

	/**
	 * Need privileges to update item
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'manage_sc_shop_settings' );
	}
}
