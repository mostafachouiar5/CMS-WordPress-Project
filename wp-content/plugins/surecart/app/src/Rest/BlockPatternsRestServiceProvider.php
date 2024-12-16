<?php
namespace SureCart\Rest;

use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * REST API: BlockPatternsRestServiceProvider class
 *
 * @package    WordPress
 * @subpackage REST_API
 * @since      6.0.0
 */

/**
 * Core class used to access block patterns via the REST API.
 *
 * @since 6.0.0
 *
 * @see WP_REST_Controller
 */
class BlockPatternsRestServiceProvider extends \WP_REST_Controller implements ServiceProviderInterface {
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
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Constructs the controller.
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		$this->namespace = 'surecart/v1';
		$this->rest_base = 'form-patterns';
	}

	/**
	 * Registers the routes for the objects of the controller.
	 *
	 * @since 6.0.0
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);
	}

	/**
	 * Checks whether a given request has permission to read block patterns.
	 *
	 * @since 6.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		if ( current_user_can( 'edit_posts' ) ) {
			return true;
		}

		foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				return true;
			}
		}

		return new \WP_Error(
			'rest_cannot_view',
			__( 'Sorry, you are not allowed to view the registered form patterns.', 'surecart' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}

	/**
	 * Retrieves all block patterns.
	 *
	 * @since 6.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_items( $request ) {
		$response = array();
		$patterns = \WP_Block_Patterns_Registry::get_instance()->get_all_registered();
		$filtered = array_filter(
			$patterns,
			function( $pattern ) {
				return in_array( 'surecart_form', $pattern['categories'] ?? [] );
			}
		);
		foreach ( $filtered as $pattern ) {
			$prepared_pattern = $this->prepare_item_for_response( $pattern, $request );
			$response[]       = $this->prepare_response_for_collection( $prepared_pattern );
		}
		return rest_ensure_response( $response );
	}

	/**
	 * Prepare a raw block pattern before it gets output in a REST API response.
	 *
	 * @since 6.0.0
	 *
	 * @param array           $item    Raw pattern as registered, before any changes.
	 * @param WP_REST_Request $request Request object.
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function prepare_item_for_response( $item, $request ) {
		$fields = $this->get_fields_for_response( $request );
		$keys   = array(
			'name'          => 'name',
			'title'         => 'title',
			'description'   => 'description',
			'viewportWidth' => 'viewport_width',
			'blockTypes'    => 'block_types',
			'categories'    => 'categories',
			'keywords'      => 'keywords',
			'content'       => 'content',
			'inserter'      => 'inserter',
		);
		$data   = array();
		foreach ( $keys as $item_key => $rest_key ) {
			if ( isset( $item[ $item_key ] ) && rest_is_field_included( $rest_key, $fields ) ) {
				$data[ $rest_key ] = $item[ $item_key ];
			}
		}

		$context = ! empty( $request['context'] ) ? $request['context'] : 'view';
		$data    = $this->add_additional_fields_to_object( $data, $request );
		$data    = $this->filter_response_by_context( $data, $context );
		return rest_ensure_response( $data );
	}

	/**
	 * Retrieves the block pattern schema, conforming to JSON Schema.
	 *
	 * @since 6.0.0
	 *
	 * @return array Item schema data.
	 */
	public function get_item_schema() {
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'block-pattern',
			'type'       => 'object',
			'properties' => array(
				'name'           => array(
					'description' => __( 'The pattern name.', 'surecart' ),
					'type'        => 'string',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'title'          => array(
					'description' => __( 'The pattern title, in human readable format.', 'surecart' ),
					'type'        => 'string',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'description'    => array(
					'description' => __( 'The pattern detailed description.', 'surecart' ),
					'type'        => 'string',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'viewport_width' => array(
					'description' => __( 'The pattern viewport width for inserter preview.', 'surecart' ),
					'type'        => 'number',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'block_types'    => array(
					'description' => __( 'Block types that the pattern is intended to be used with.', 'surecart' ),
					'type'        => 'array',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'categories'     => array(
					'description' => __( 'The pattern category slugs.', 'surecart' ),
					'type'        => 'array',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'keywords'       => array(
					'description' => __( 'The pattern keywords.', 'surecart' ),
					'type'        => 'array',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'content'        => array(
					'description' => __( 'The pattern content.', 'surecart' ),
					'type'        => 'string',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'inserter'       => array(
					'description' => __( 'Determines whether the pattern is visible in inserter.', 'surecart' ),
					'type'        => 'boolean',
					'readonly'    => true,
					'context'     => array( 'view', 'edit', 'embed' ),
				),
			),
		);

		return $this->add_additional_fields_schema( $schema );
	}
}
