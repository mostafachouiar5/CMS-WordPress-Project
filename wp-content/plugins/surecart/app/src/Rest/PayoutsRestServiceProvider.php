<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\PayoutsController;

/**
 * Service provider for payout REST Requests
 */
class PayoutsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'payouts';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = PayoutsController::class;

	/**
	 * Methods allowed for the model
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find', 'create', 'delete' ];

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/complete/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'complete' ),
					'permission_callback' => [ $this, 'complete_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/make_processing/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'make_processing' ),
					'permission_callback' => [ $this, 'make_processing_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
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
				'id' => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'readonly'    => true,
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Who can list payouts
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to list items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_affiliates' );
	}

	/**
	 * Who can get a specific payout
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to get an item, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_affiliates' );
	}

	/**
	 * Who can create a payout
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_affiliates' );
	}

	/**
	 * Who can delete a payout
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to delete an item, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_affiliates' );
	}

	/**
	 * Who can complete a payout
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to complete an item, WP_Error object otherwise.
	 */
	public function complete_permissions_check( $request ) {
		return get_current_user( 'edit_sc_affiliates' );
	}

	/**
	 * Who can make a payout processing
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to make a payout processing, WP_Error object otherwise.
	 */
	public function make_processing_permissions_check( $request ) {
		return get_current_user( 'edit_sc_affiliates' );
	}
}
