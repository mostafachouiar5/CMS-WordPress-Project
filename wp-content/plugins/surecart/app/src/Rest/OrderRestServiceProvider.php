<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\OrderController;
use SureCart\Models\User;

/**
 * Service provider for Price Rest Requests
 */
class OrderRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'orders';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = OrderController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'find' ];

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
	 * Filters a response based on the context defined in the schema.
	 *
	 * @since 4.7.0
	 *
	 * @param array|\WP_REST_Response $data    Response data to filter.
	 * @param string                  $context Context defined in the schema.
	 * @return array Filtered response.
	 */
	public function filter_response_by_context( $data, $context ) {
		$schema = $this->get_item_schema();

		// if the user can edit customers, show the edit context.
		if ( current_user_can( 'edit_sc_customers' ) ) {
			return rest_filter_response_by_context( $data, $schema, 'edit' );
		}

		$data = is_a( $data, 'WP_REST_Response' ) ? $data->get_data() : $data;

		// if the user is logged in, and we have customer data.
		// if it matches the current customer, then we can show the edit context.
		if ( is_user_logged_in() && ! empty( $data['customer'] ) ) {
			$customer_id = ! empty( $data['customer']['id'] ) ? $data['customer']['id'] : $data['customer'];
			if ( User::current()->customerId() === $customer_id ) {
				return rest_filter_response_by_context( $data, $schema, 'edit' );
			}
		}

		return rest_filter_response_by_context( $data, $schema, 'view' );
	}


	/**
	 * Anyone can get a specific order if they have the unique order id.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_order', $request['id'] );
	}

	/**
	 * Listing
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_orders', $request->get_params() );
	}
}
