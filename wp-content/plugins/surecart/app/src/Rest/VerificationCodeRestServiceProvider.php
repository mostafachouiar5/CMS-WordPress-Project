<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\CheckEmailController;
use SureCart\Rest\RestServiceInterface;
use SureCart\Controllers\Rest\VerificationCodeController;

/**
 * Service provider for Price Rest Requests
 */
class VerificationCodeRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'verification_codes';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = VerificationCodeController::class;

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [ 'create' ];

	/**
	 * Register additional routes (the /verify route).
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/verify/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'verify' ),
					'permission_callback' => [ $this, 'verify_permissions_check' ],
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
			'$schema' => 'http://json-schema.org/draft-04/schema#',
			// The title property marks the identity of the resource.
			'title'   => $this->endpoint,
			'type'    => 'object',
		];

		return $this->schema;
	}

	/**
	 * Anyone can get verify a code.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true
	 */
	public function verify_permissions_check( $request ) {
		return true;
	}

	/**
	 * Must be a WordPress user to generate a verification code.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return boolean
	 */
	public function create_item_permissions_check( $request ) {
		return ( new CheckEmailController() )->checkEmail( $request );
	}
}
