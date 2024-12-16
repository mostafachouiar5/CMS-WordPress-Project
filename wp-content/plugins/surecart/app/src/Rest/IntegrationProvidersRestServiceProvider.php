<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\IntegrationProvidersController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Price Rest Requests
 */
class IntegrationProvidersRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = IntegrationProvidersController::class;

	/**
	 * Register Additional REST Routes
	 *
	 * @return void
	 */
	public function registerModelRoutes() {
		// List available providers for a specific model.
		register_rest_route(
			"$this->name/v$this->version",
			'integration_providers',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => $this->callback( $this->controller, 'index' ),
					'permission_callback' => [ $this, 'get_items_permission_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		// Find a specific provider data.
		register_rest_route(
			"$this->name/v$this->version",
			'integration_providers/(?P<provider>\S+)',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => $this->callback( $this->controller, 'find' ),
					'permission_callback' => [ $this, 'get_item_permission_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		// list all item choices for the provider.
		register_rest_route(
			"$this->name/v$this->version",
			'integration_provider_items',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => $this->callback( $this->controller, 'items' ),
					'permission_callback' => [ $this, 'get_items_permission_check' ],
				],
				// Register our schema callback .
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		// list all item choices for the provider.
		register_rest_route(
			"$this->name/v$this->version",
			'integration_provider_items/(?P<id>\S+)',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => $this->callback( $this->controller, 'item' ),
					'permission_callback' => [ $this, 'get_item_permission_check' ],
				],
				// Register our schema callback .
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
			'model'    => [
				'description' => __( 'The model to get integration providers for.', 'surecart' ),
				'type'        => 'string',
			],
			'page'     => [
				'description' => esc_html__( 'The page of items you want returned.', 'surecart' ),
				'type'        => 'integer',
			],
			'per_page' => [
				'description' => esc_html__( 'A limit on the number of items to be returned, between 1 and 100.', 'surecart' ),
				'type'        => 'integer',
				'minimum'     => 1,
				'maximum'     => 100,
			],
		];
	}

	/**
	 * List permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permission_check( $request ) {
		return current_user_can( 'read_sc_products' );
	}

	/**
	 * List permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permission_check( $request ) {
		return current_user_can( 'read_sc_products' );
	}
}
