<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\ExportsController;

/**
 * Service provider for the exports REST Requests
 */
class ExportsRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'exports';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = ExportsController::class;

	/**
	 * Methods allowed for the model
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find', 'create' ];

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
	 * Who can list exports
	 *
	 * @param \WP_REST_Request $request The request object.
	 * @return true|\WP_Error True if the request has read access, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'manage_sc_shop_settings' );
	}

	/**
	 * Who can create exports
	 *
	 * @param \WP_REST_Request $request The request object.
	 * @return true|\WP_Error True if the request has create access, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		$type = $request->get_params()['type'] ?? '';

		if ( 'payouts' === $type ) {
			return current_user_can( 'publish_sc_affiliates' );
		}

		return current_user_can( 'publish_sc_' . $type );
	}

	/**
	 * Who can get an export
	 *
	 * @param \WP_REST_Request $request The request object.
	 * @return true|\WP_Error True if the request has read access, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'manage_sc_shop_settings' );
	}
}
