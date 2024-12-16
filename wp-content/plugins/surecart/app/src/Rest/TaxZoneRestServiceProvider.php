<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\TaxZoneController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class TaxZoneRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'tax_zones';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = TaxZoneController::class;

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
				'id'         => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'created_at' => [
					'type'    => 'integer',
					'context' => [ 'view', 'edit', 'embed' ],
				],
				'updated_at' => [
					'type'    => 'integer',
					'context' => [ 'view', 'edit', 'embed' ],
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Get Items
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'manage_options' );
	}
}
