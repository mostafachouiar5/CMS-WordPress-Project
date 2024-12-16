<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\SiteHealthController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Shipping Zone Rest Requests
 */
class SiteHealthRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'site-health';

	/**
	 * Methods allowed for the model.
	 *
	 * @var array
	 */
	protected $methods = [];

	/**
	 * Register routes required to work.
	 *
	 * @return void
	 */
	public function registerRoutes() {
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/api-connectivity/',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => [ \SureCart::healthCheck(), 'apiTest' ],
					'permission_callback' => function() {
						return $this->permission( 'surecart_api_connectivity' );
					},
				],
			]
		);
		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/webhooks/',
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => [ \SureCart::healthCheck(), 'webhooksTest' ],
					'permission_callback' => function() {
						return $this->permission( 'surecart_webhooks' );
					},
				],
			]
		);
	}

	/**
	 * Retrieve permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function permission( $check ) {
		$default_capability = 'view_site_health_checks';

		/**
		 * Filters the capability needed to run a given Site Health check.
		 *
		 * @since 5.6.0
		 *
		 * @param string $default_capability The default capability required for this check.
		 * @param string $check              The Site Health check being performed.
		 */
		$capability = apply_filters( "site_health_test_rest_capability_{$check}", $default_capability, $check );

		return current_user_can( $capability );
	}
}
