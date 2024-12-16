<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\ProductsController;

/**
 * Service provider for Price Rest Requests
 */
class ProductsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'products';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ProductsController::class;

	/**
	 * Register Additional REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/sync/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'sync' ),
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/sync_all',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'syncAll' ),
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
				'id'              => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'file_upload_ids' => [
					'description' => esc_html__( 'Files attached to the product.', 'surecart' ),
					'context'     => [ 'edit' ],
					'type'        => 'array',
					'items'       => [
						'type' => 'string',
					],
				],
				'metadata'        => [
					'description' => esc_html__( 'Stored product metadata', 'surecart' ),
					'type'        => 'object',
					'properties'  => [
						'wp_created_by' => [
							'type'     => 'integer',
							'context'  => [ 'edit' ],
							'readonly' => true,
						],
					],
				],
				'metrics'         => [
					'description' => esc_html__( 'Top level metrics for the product.', 'surecart' ),
					'readonly'    => true,
					'type'        => 'object',
					'properties'  => [
						'currency'         => [
							'type' => 'string',
						],
						'max_price_amount' => [
							'type' => 'integer',
						],
						'min_price_amount' => [
							'type' => 'integer',
						],
						'prices_count'     => [
							'type' => 'integer',
						],
					],
					'context'     => [ 'edit' ],
				],
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
			'archived'               => [
				'description' => esc_html__( 'Whether to get archived products or not.', 'surecart' ),
				'type'        => 'boolean',
			],
			'recurring'              => [
				'description' => esc_html__( 'Only return products that are recurring or not recurring (one time).', 'surecart' ),
				'type'        => 'boolean',
			],
			'query'                  => [
				'description' => __( 'The query to be used for full text search of this collection.', 'surecart' ),
				'type'        => 'string',
			],
			'ids'                    => [
				'description' => __( 'Ensure result set excludes specific IDs.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
			'product_group_ids'      => [
				'description' => __( 'Only return objects that belong to the given product groups.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
			'product_collection_ids' => [
				'description' => __( 'Only return objects that belong to the given product collections.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
			'page'                   => [
				'description' => esc_html__( 'The page of items you want returned.', 'surecart' ),
				'type'        => 'integer',
			],
			'per_page'               => [
				'description' => esc_html__( 'A limit on the number of items to be returned, between 1 and 100.', 'surecart' ),
				'type'        => 'integer',
			],
		];
	}

	/**
	 * Anyone can get a specific product.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		if ( 'edit' === $request['context'] && ! current_user_can( 'edit_sc_products' ) ) {
			return new \WP_Error(
				'rest_forbidden_context',
				__( 'Sorry, you are not allowed to edit products.', 'surecart' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}

	/**
	 * Who can list products?
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		if ( 'edit' === $request['context'] && ! current_user_can( 'edit_sc_products' ) ) {
			return new \WP_Error(
				'rest_forbidden_context',
				__( 'Sorry, you are not allowed to edit products.', 'surecart' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		if ( $request['archived'] ) {
			return current_user_can( 'edit_sc_products' );
		}

		return true;
	}

	/**
	 * Create model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		$request['context'] = 'edit';
		return current_user_can( 'publish_sc_products' );
	}

	/**
	 * Update model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		$request['context'] = 'edit';
		return current_user_can( 'edit_sc_products' );
	}

	/**
	 * Delete model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		$request['context'] = 'edit';
		return current_user_can( 'delete_sc_products' );
	}

	/**
	 * If we are editing, let's make sure the data comes back directly.
	 *
	 * @param \SureCart\Models\Product $model Product model.
	 * @param string                   $context The context of the request.
	 *
	 * @return  array The filtered response.
	 */
	public function filter_response_by_context( $model, $context ) {
		$response = parent::filter_response_by_context( $model, $context );

		if ( 'edit' === $context && is_array( $response ) && ! empty( $response['id'] ) ) {
			// Process the variants, it's in a data column, so we need to pull it out.
			$response['variants'] = ! empty( $response['variants']['data'] ) ? $response['variants']['data'] : [];
			// Process the variant_options, it's in a data column, so we need to pull it out.
			$response['variant_options'] = ! empty( $response['variant_options']['data'] ) ? $response['variant_options']['data'] : [];
		}

		return $response;
	}
}
