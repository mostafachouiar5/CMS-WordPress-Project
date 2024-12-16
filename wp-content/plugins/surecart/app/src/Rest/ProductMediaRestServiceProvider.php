<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\ProductMediaController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Product Medias Rest Requests
 */
class ProductMediaRestServiceProvider extends RestServiceProvider implements RestServiceInterface {

	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'product_medias';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ProductMediaController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'create', 'find', 'edit', 'delete' ];

	/**
	 * Register Additional REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/download/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'download' ),
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
				'id'      => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit', 'embed' ),
					'readonly'    => true,
				],
				'content' => array(
					'description' => esc_html__( 'The content for the object.', 'surecart' ),
					'type'        => 'string',
				),
			],
		];

		return $this->schema;
	}

	/**
	 * Get the collection params.
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return [
			'ids'         => [
				'description' => __( 'Ensure result set excludes specific IDs.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
			'product_ids' => [
				'description' => __( 'Only return objects that belong to the given products.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
			'page'        => [
				'description' => esc_html__( 'The page of items you want returned.', 'surecart' ),
				'type'        => 'integer',
			],
			'per_page'    => [
				'description' => esc_html__( 'A limit on the number of items to be returned, between 1 and 100.', 'surecart' ),
				'type'        => 'integer',
			],
			'limit'       => [
				'description' => esc_html__( 'A limit on the number of records returned', 'surecart' ),
				'type'        => 'integer',
			],

		];
	}

	/**
	 * Anyone can get a specific product media.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return true;
	}

	/**
	 * Who can list product media
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		if ( $request['archived'] ) {
			return current_user_can( 'edit_sc_products' );
		}

		return true;
	}

	/**
	 * Create product media.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_products' );
	}

	/**
	 * Update product media.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_products' );
	}

	/**
	 * Delete product media.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_products' );
	}
}
