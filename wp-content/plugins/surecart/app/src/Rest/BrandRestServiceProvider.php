<?php

namespace SureCart\Rest;

use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\BrandController;

/**
 * Service provider for Price Rest Requests
 */
class BrandRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'brand';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = BrandController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [];

	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			"$this->endpoint",
			array_filter(
				[
					[
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => $this->callback( $this->controller, 'find' ),
						'permission_callback' => [ $this, 'get_item_permissions_check' ],
						'args'                => $this->get_collection_params(),
					],
					[
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => $this->callback( $this->controller, 'edit' ),
						'permission_callback' => [ $this, 'update_item_permissions_check' ],
					],
					'schema' => [ $this, 'get_item_schema' ],
				]
			)
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/purge_logo/',
			[
				[
					'methods'             => \WP_REST_Server::DELETABLE,
					'callback'            => $this->callback( $this->controller, 'purgeLogo' ),
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
				'id'               => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'object'           => [
					'description' => esc_html__( 'Type of object (Account)', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'created_at'       => [
					'description' => esc_html__( 'Created at timestamp', 'surecart' ),
					'type'        => 'integer',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
				'updated_at'       => [
					'description' => esc_html__( 'Created at timestamp', 'surecart' ),
					'type'        => 'integer',
					'context'     => [ 'edit' ],
					'readonly'    => true,
				],
				'color'            => [
					'description' => esc_html__( 'The brand color.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'email'            => [
					'description' => esc_html__( 'The email address that will be shown to customers for support, on invoices, etc.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'phone'            => [
					'description' => esc_html__( 'The phone number that will be shown to customers for support, on invoices, etc.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'website'          => [
					'description' => esc_html__( 'The website that will be shown to customers for support, on invoices, etc.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'logo_url'         => [
					'description' => esc_html__( 'The URL of the brand logo.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'address'          => [
					'description' => esc_html__( 'The associated address.', 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'view', 'edit' ],
				],
				'statement_memo'   => [
					'description' => esc_html__( 'The default memo for invoices and receipts.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'statement_footer' => [
					'description' => esc_html__( 'The default footer for invoices and receipts.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Get items
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return true;
	}

	/**
	 * Update item
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'manage_options' );
	}
}
