<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\DraftCheckoutsController;

/**
 * Service provider for Price Rest Requests
 */
class DraftCheckoutRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'draft-checkouts';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = DraftCheckoutsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'create', 'find', 'edit' ];

	/**
	 * Register Additional REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/finalize/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'finalize' ),
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/manually_pay/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'manuallyPay' ),
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
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
				'id'          => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'currency'    => [
					'description' => esc_html__( 'The currency for the session.', 'surecart' ),
					'type'        => 'string',
				],
				'metadata'    => [
					'description' => esc_html__( 'Metadata for the order.', 'surecart' ),
					'type'        => 'object',
				],
				'customer_id' => [
					'description' => esc_html__( 'The customer id for the order.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'edit' ],
				],
				'customer'    => [
					'description' => esc_html__( 'The customer for the session.', 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'edit' ],
				],
				'line_items'  => [
					'description' => esc_html__( 'The line items for the session.', 'surecart' ),
					'type'        => 'object',
				],
				'discount'    => [
					'description' => esc_html__( 'The discount for the session.', 'surecart' ),
					'type'        => 'object',
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Read checkout.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_checkouts' );
	}

	/**
	 * List checkouts.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_checkouts' );
	}

	/**
	 * Create checkout.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return $this->update_item_permissions_check( $request );
	}

	/**
	 * Update checkout.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_checkouts' );
	}

	/**
	 * Nobody can delete.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return false
	 */
	public function delete_item_permissions_check( $request ) {
		return $this->update_item_permissions_check( $request );
	}
}
