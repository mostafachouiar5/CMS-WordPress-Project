<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\ActivationsController;

/**
 * Service provider for Price Rest Requests
 */
class ActivationRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'activations';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ActivationsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'edit', 'create', 'find', 'delete' ];

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
				'fingerprint' => [
					'description' => esc_html__( 'The unique identifier for this activation. For example a URL, a machine fingerprint, etc.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'required'    => true,
				],
				'name'        => [
					'description' => esc_html__( 'The name of this activation.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'license'     => [
					'description' => esc_html__( 'The UUID of the license.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'required'    => true,
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
			'page'        => [
				'description' => esc_html__( 'The page of items you want returned.', 'surecart' ),
				'type'        => 'integer',
			],
			'per_page'    => [
				'description' => esc_html__( 'A limit on the number of items to be returned, between 1 and 100.', 'surecart' ),
				'type'        => 'integer',
			],
			'ids'         => [
				'description' => __( 'Ensure result set excludes specific IDs.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
			'license_ids' => [
				'description' => __( 'Ensure result set excludes specific license IDs.', 'surecart' ),
				'type'        => 'array',
				'items'       => [
					'type' => 'string',
				],
				'default'     => [],
			],
		];
	}

	/**
	 * Get file
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_activation', $request['id'] );
	}

	/**
	 * List files.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_activations' );
	}

	/**
	 * Create model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_activations' );
	}

	/**
	 * Update model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_activation', $request['id'], $request->get_params() );
	}

	/**
	 * Delete model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_activation', $request['id'], $request->get_params() );
	}
}
