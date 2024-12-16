<?php

namespace SureCart\Rest;

use SureCart\Models\Model;
use SureCart\Rest\RestServiceInterface;

/**
 * Abstract Rest Service Provider interface
 */
abstract class RestServiceProvider extends \WP_REST_Controller implements RestServiceInterface {
	/**
	 * Mark specific properties that need additional permissions checks
	 * before modifying. We don't want customers being able to modify these.
	 *
	 * @var array
	 */
	protected $property_permissions = [];

	/**
	 * Plugin namespace.
	 *
	 * @var string
	 */
	protected $name = 'surecart';

	/**
	 * API Version
	 *
	 * @var string
	 */
	protected $version = '1';

	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = '';

	/**
	 * Controller class
	 *
	 * @var string
	 */
	protected $controller = '';

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'index', 'create', 'find', 'edit', 'delete' ];

	/**
	 * {@inheritDoc}
	 *
	 * @param  \Pimple\Container $container Service Container.
	 */
	public function register( $container ) {
		// nothing to register.
	}

	/**
	 * Bootstrap routes
	 *
	 * @param  \Pimple\Container $container Service Container.
	 *
	 * @return void
	 */
	public function bootstrap( $container ) {
		add_action( 'rest_api_init', [ $this, 'registerModelRoutes' ] );
	}

	/**
	 * Do we have the method
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function hasMethod( $name ) {
		return in_array( $name, $this->methods, true );
	}

	/**
	 * Do we have all these methods.
	 *
	 * @param array $methods Array of method names.
	 * @return boolean
	 */
	public function hasAnyMethods( $methods = [] ) {
		foreach ( $methods as $method ) {
			if ( $this->hasMethod( $method ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerModelRoutes() {
		$this->registerRoutes();
		if ( $this->hasAnyMethods( [ 'index', 'create' ] ) ) {
			register_rest_route(
				"$this->name/v$this->version",
				"$this->endpoint",
				array_filter(
					[
						( $this->hasMethod( 'index' ) ? [
							'methods'             => \WP_REST_Server::READABLE,
							'callback'            => $this->callback( $this->controller, 'index' ),
							'permission_callback' => [ $this, 'get_items_permissions_check' ],
							'args'                => $this->get_collection_params(),
						] : [] ),
						( $this->hasMethod( 'create' ) ? [
							'methods'             => \WP_REST_Server::CREATABLE,
							'callback'            => $this->callback( $this->controller, 'create' ),
							'permission_callback' => [ $this, 'create_item_permissions_check' ],
						] : [] ),
						'schema' => [ $this, 'get_item_schema' ],
					]
				)
			);
		}

		if ( $this->hasAnyMethods( [ 'find', 'edit', 'delete' ] ) ) {
			register_rest_route(
				"$this->name/v$this->version",
				$this->endpoint . '/(?P<id>[^/]+)',
				array_filter(
					[
						( $this->hasMethod( 'find' ) ? [
							'methods'             => \WP_REST_Server::READABLE,
							'callback'            => $this->callback( $this->controller, 'find' ),
							'permission_callback' => [ $this, 'get_item_permissions_check' ],
						] : [] ),
						( $this->hasMethod( 'edit' ) ? [
							'methods'             => \WP_REST_Server::EDITABLE,
							'callback'            => $this->callback( $this->controller, 'edit' ),
							'permission_callback' => [ $this, 'update_item_permissions_check' ],
						] : [] ),
						( $this->hasMethod( 'delete' ) ? [
							'methods'             => \WP_REST_Server::DELETABLE,
							'callback'            => $this->callback( $this->controller, 'delete' ),
							'permission_callback' => [ $this, 'delete_item_permissions_check' ],
						] : [] ),
						// Register our schema callback.
						'schema' => [ $this, 'get_item_schema' ],
					]
				)
			);
		}
	}

	/**
	 * Additional routes to register for the model.
	 *
	 * @return void
	 */
	public function registerRoutes() {
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
	 * Process the callback for the route.
	 *
	 * @param string $class Class name.
	 * @param string $method Class method.
	 * @return callback
	 */
	public function callback( $class, $method ) {
		// litespeed caching bypass.
		do_action( 'litespeed_control_set_nocache', 'surecart api request' );

		return function ( $request ) use ( $class, $method ) {
			// get and call controller with request.
			$controller = \SureCart::closure()->method( $class, $method );
			$model      = $controller( $request );

			// check and filter context.
			$context = ! empty( $request['context'] ) ? $request['context'] : 'view';

			if ( is_wp_error( $model ) ) {
				return $model;
			}

			// remove wp_created_by to prevent user ids from being leaked.
			if ( 'edit' !== $context && ! empty( $model->metadata->wp_created_by ) ) {
				unset( $model->metadata->wp_created_by );
			}

			$response = rest_ensure_response( $this->filter_response_by_context( is_a( $model, Model::class ) ? $model->toArray() : $model, $context ) );

			if ( is_a( $model, Model::class ) && ! empty( $model->getCacheStatus() ) ) {
				$response->header( 'X-SURECART-CACHE-STATUS', $model->getCacheStatus() );
			}

			return $response;
		};
	}

	/**
	 * Check permissions for specific properties of the request.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @param array            $keys Keys to check.
	 *
	 * @return boolean
	 */
	protected function requestOnlyHasKeys( $request, $keys ) {
		$keys = array_merge( $keys, [ 'context', '_locale', 'rest_route', 'id', 'expand' ] );
		foreach ( $request->get_params() as $key => $value ) {
			if ( ! in_array( $key, $keys, true ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Retrieves the query params for collections.
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return [];
	}

	/**
	 * Set these all as false by default
	 * in case parent class doesn't implement them.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 *
	 * @return false
	 */
	public function get_item_permissions_check( $request ) {
		return false;
	}

	/**
	 * Set these all as false by default
	 * in case parent class doesn't implement them.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 *
	 * @return false
	 */
	public function get_items_permissions_check( $request ) {
		return false;
	}

	/**
	 * Set these all as false by default
	 * in case parent class doesn't implement them.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 *
	 * @return false
	 */
	public function create_item_permissions_check( $request ) {
		return false;
	}

	/**
	 * Set these all as false by default
	 * in case parent class doesn't implement them.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 *
	 * @return false
	 */
	public function update_item_permissions_check( $request ) {
		return false;
	}

	/**
	 * Set these all as false by default
	 * in case parent class doesn't implement them.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 *
	 * @return false
	 */
	public function delete_item_permissions_check( $request ) {
		return false;
	}
}
