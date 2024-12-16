<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\StatisticsController;

/**
 * Service provider for Price Rest Requests
 */
class StatisticRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'stats';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = StatisticsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'find' ];

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
	 * Get the collection params.
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return [
			'page'     => [
				'description' => esc_html__( 'The page of items you want returned.', 'surecart' ),
				'type'        => 'integer',
			],
			'per_page' => [
				'description' => esc_html__( 'A limit on the number of items to be returned, between 1 and 100.', 'surecart' ),
				'type'        => 'integer',
			],
			'currency' => [
				'description' => esc_html__( "Only return objects that have this currency. If not set, this will fallback to the account's default currency.", 'surecart' ),
				'type'        => 'string',
				'context'     => [ 'view', 'edit', 'embed' ],
			],
			'end_at'   => [
				'description' => esc_html__( 'The end of the date range to query.', 'surecart' ),
				'type'        => 'string',
				'context'     => [ 'view', 'edit', 'embed' ],
				'required'    => true,
			],
			'interval' => [
				'description' => esc_html__( 'The interval to group statistics on – one of hour, day, week, month, or year.', 'surecart' ),
				'type'        => 'string',
				'context'     => [ 'view', 'edit', 'embed' ],
				'required'    => true,
			],
			'start'    => [
				'description' => esc_html__( 'The start of the date range to query.', 'surecart' ),
				'type'        => 'string',
				'context'     => [ 'view', 'edit', 'embed' ],
				'required'    => true,
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
		return current_user_can( 'manage_sc_shop_settings' );
	}
}
