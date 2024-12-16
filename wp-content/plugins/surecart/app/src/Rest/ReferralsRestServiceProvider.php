<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\ReferralsController;

/**
 * Service provider for the referrals REST Requests
 */
class ReferralsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'referrals';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ReferralsController::class;

	/**
	 * Methods allowed for the model
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find', 'edit', 'create', 'delete' ];

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/approve/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'approve' ),
					'permission_callback' => [ $this, 'approve_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/deny/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'deny' ),
					'permission_callback' => [ $this, 'deny_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/make_reviewing/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'make_reviewing' ),
					'permission_callback' => [ $this, 'make_reviewing_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);
	}

	/**
	 * Get our sample schema for a post
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
	 * Who can list referrals?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to list items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_affiliates' );
	}

	/**
	 * Who can get a specific referral?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to get an item, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_affiliates' );
	}

	/**
	 * Who can create a referral?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_affiliates' );
	}

	/**
	 * Who can update a referral?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to update an item, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_affiliates' );
	}

	/**
	 * Who can delete a referral?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to delete an item, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_affiliates' );
	}

	/**
	 * Who can approve a referral?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to approve an item, WP_Error object otherwise.
	 */
	public function approve_permissions_check( $request ) {
		return current_user_can( 'edit_sc_affiliates' );
	}

	/**
	 * Who can deny a referral?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to deny an item, WP_Error object otherwise.
	 */
	public function deny_permissions_check( $request ) {
		return current_user_can( 'edit_sc_affiliates' );
	}

	/**
	 * Who can make a referral reviewing?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to make a referral reviewing, WP_Error object otherwise.
	 */
	public function make_reviewing_permissions_check( $request ) {
		return current_user_can( 'edit_sc_affiliates' );
	}
}
