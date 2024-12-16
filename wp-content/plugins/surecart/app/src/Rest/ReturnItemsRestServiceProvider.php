<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\ReturnItemsController;

/**
 * Service provider for ReturnItems rest requests
 */
class ReturnItemsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'return_items';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ReturnItemsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find' ];

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
	 * Who can read return items
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to read return items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_orders' );
	}

	/**
	 * Who can read a return item
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return true|\WP_Error True if the request has access to read return item, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_orders' );
	}
}
