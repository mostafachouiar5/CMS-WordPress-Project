<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\UploadsController;

/**
 * Service provider for Price Rest Requests
 */
class UploadsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {

	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'uploads';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = UploadsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'create' ];

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
	 * Create model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'upload_files' ) && current_user_can( 'edit_sc_products' );
	}
}
