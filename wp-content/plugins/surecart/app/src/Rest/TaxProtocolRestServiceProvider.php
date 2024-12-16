<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\TaxProtocolController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class TaxProtocolRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'tax_protocol';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = TaxProtocolController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [];

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
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
				'id'                         => [
					'description' => esc_html__( 'Unique identifier for the object.', 'surecart' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit', 'embed' ],
					'readonly'    => true,
				],
				'created_at'                 => [
					'type'    => 'integer',
					'context' => [ 'view', 'edit', 'embed' ],
				],
				'updated_at'                 => [
					'type'    => 'integer',
					'context' => [ 'view', 'edit', 'embed' ],
				],
				'ca_tax_enabled'             => [
					'description' => esc_html__( 'If set to true GST taxes will be calculated for all Canadian provinces.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'eu_micro_exemption_enabled' => [
					'description' => esc_html__( "If set to true VAT taxes will be calculated using the account's home country VAT rate.", 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'eu_tax_enabled'             => [
					'description' => esc_html__( 'If set to true VAT taxes will be calculated for all EU countries.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'tax_enabled'                => [
					'description' => esc_html__( 'If set to true taxes will be automatically calculated.', 'surecart' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'address'                    => [
					'description' => esc_html__( 'Upgrade behavior. Either pending or immediate.', 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'ca_tax_identifier'          => [
					'description' => esc_html__( 'The associated Canadian tax identifier.', 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
				'eu_tax_identifier'          => [
					'description' => esc_html__( 'The associated EU tax identifier.', 'surecart' ),
					'type'        => 'object',
					'context'     => [ 'view', 'edit', 'embed' ],
				],
			],
		];

		return $this->schema;
	}

	/**
	 * Anyone can get the protocols.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Need priveleges to update.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'manage_options' );
	}
}
