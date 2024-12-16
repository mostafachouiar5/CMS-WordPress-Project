<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\UpsellsController;

/**
 * Service provider for Price Rest Requests
 */
class UpsellRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'upsells';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = UpsellsController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'create', 'find', 'edit', 'delete' ];

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
				'id'                          => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'object'                      => [
					'description' => esc_html__( 'Type of object (upsell)', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'created_at'                  => [
					'description' => esc_html__( 'Created at timestamp', 'surecart' ),
					'type'        => 'integer',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'updated_at'                  => [
					'description' => esc_html__( 'Created at timestamp', 'surecart' ),
					'type'        => 'integer',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'amount_off'                  => [
					'description' => esc_html__( 'Amount (in the currency of the price) that will be taken off line items associated with this upsell.', 'surecart' ),
					'type'        => [ 'integer', 'null' ],
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'duplicate_purchase_behavior' => [
					'description' => esc_html__( 'How to handle duplicate purchases of the product – can be one of allow, block_within_checkout, or block.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'fee_description'             => [
					'description' => esc_html__( 'The description for this upsell which will be visible to customers.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'percent_off'                 => [
					'description' => esc_html__( 'Percent that will be taken off line items associated with this upsell.', 'surecart' ),
					'type'        => [ 'integer', 'null' ],
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'step'                        => [
					'description' => esc_html__( 'Where this upsell falls in position within the upsell funnel – can be one of initial, accepted, or declined.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'price'                       => [
					'description' => esc_html__( 'The UUID of the price.', 'surecart' ),
					'type'        => [ 'string', 'object' ],
					'context'     => [ 'view', 'edit', 'embed' ],
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Anyone can get a specific price.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return true;
	}

	/**
	 * Who can list prices
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		if ( empty( $request['upsell_funnel_ids'] ) || count( $request['upsell_funnel_ids'] ) > 1 ) {
			return current_user_can( 'edit_sc_prices' );
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
		return current_user_can( 'publish_sc_prices' );
	}

	/**
	 * Update model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_prices' );
	}

	/**
	 * Delete model.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_prices' );
	}
}
