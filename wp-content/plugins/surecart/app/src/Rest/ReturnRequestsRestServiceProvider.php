<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\ReturnRequestsController;

/**
 * Service provider for ReturnRequest rest requests
 */
class ReturnRequestsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'return_requests';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ReturnRequestsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find', 'create', 'edit', 'delete' ];

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/open/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'open' ),
					'permission_callback' => [ $this, 'open_item_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/complete/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'complete' ),
					'permission_callback' => [ $this, 'complete_item_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

	}

	/**
	 * Get our samples schema for a post
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
				'id' => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Who can read return requests
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to read return request, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_orders' );
	}

	/**
	 * Who can read a return request
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to read return request, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_orders' );
	}

	/**
	 * Who can create a return request
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to create return request, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_orders' );
	}

	/**
	 * Who can update a return request
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to update return request, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_orders' );
	}

	/**
	 * Who can delete a return request
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to delete return request, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_orders' );
	}

	/**
	 * Who can open a return request
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to open return request, WP_Error object otherwise.
	 */
	public function open_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_orders' );
	}

	/**
	 * Who can complete a return request
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to complete return request, WP_Error object otherwise.
	 */
	public function complete_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_orders' );
	}
}
