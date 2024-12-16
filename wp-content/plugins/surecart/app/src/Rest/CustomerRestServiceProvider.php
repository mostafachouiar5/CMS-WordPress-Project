<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\CustomerController;
use SureCart\Models\User;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class CustomerRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'customers';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = CustomerController::class;

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
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
			],
		];

		return $this->schema;
	}

		/**
		 * Get our sample schema for a post.
		 *
		 * @return array The sample schema for a post
		 */
	public function sync_schema() {
		if ( ! empty( $this->schema ) ) {
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
				'create_user' => [
					'description' => esc_html__( 'Create the WordPress user.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
					'default'     => true,
				],
				'run_actions' => [
					'description' => esc_html__( 'Run any purchase syncing actions.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
					'default'     => true,
				],
				'dry_run'     => [
					'description' => esc_html__( 'Dry run the sync.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
					'default'     => false,
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/connect/(?P<user_id>\S+)',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'connect' ),
					'permission_callback' => [ $this, 'connect_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		// sync with SureCart.
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/sync',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'sync' ),
					'permission_callback' => [ $this, 'sync_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'sync_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/expose/(?P<media_id>\S+)',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => $this->callback( $this->controller, 'exposeMedia' ),
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);
	}

	/**
	 * A WordPress user can read their own customer record.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return boolean
	 */
	public function connect_permissions_check( $request ) {
		return current_user_can( 'edit_sc_customers' );
	}

	/**
	 * A WordPress user can read their own customer record.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return boolean
	 */
	public function sync_permissions_check( $request ) {
		return current_user_can( 'edit_sc_customers' );
	}


	/**
	 * A WordPress user can read their own customer record.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_customer', $request->get_params() );
	}

	/**
	 * Read permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_customers' );
	}


	/**
	 * Create permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_customers' );
	}

	/**
	 * Update permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_customer', $request['id'], $request->get_params() );
	}

	/**
	 * Nobody can delete.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return false
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_customers' );
	}
}
