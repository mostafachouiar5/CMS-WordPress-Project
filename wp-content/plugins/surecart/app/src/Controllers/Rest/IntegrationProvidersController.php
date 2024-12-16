<?php

namespace SureCart\Controllers\Rest;

/**
 * Handle integration provider requests through the REST API
 */
class IntegrationProvidersController {
	/**
	 * List providers for the integration providers for a model.
	 * This is done through code, so we expose a filter here.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function index( \WP_REST_Request $request ) {
		$providers = apply_filters( "surecart/integrations/providers/list/{$request->get_param( 'model' )}", [], $request->get_param( 'search' ), $request );
		return rest_ensure_response( $providers );
	}

	/**
	 * List providers for the integration providers for a model.
	 * This is done through code, so we expose a filter here.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		$provider = apply_filters(
			"surecart/integrations/providers/find/{$request->get_param( 'provider' )}",
			[
				'id'             => $request->get_param( 'id' ),
				'label'          => __( 'Not Found', 'surecart' ),
				'provider_label' => __( 'The integration has been removed or is unavailable.', 'surecart' ),
			],
			$request
		);
		return rest_ensure_response( $provider );
	}

	/**
	 * List the items to choose from when the provider is chosen.
	 * This is done through code, so we expose a filter here.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function items( \WP_REST_Request $request ) {
		if ( $request['id'] ) {
			return $this->item( $request );
		}

		$providers = apply_filters( "surecart/integrations/providers/{$request->get_param( 'provider' )}/{$request->get_param( 'model' )}/items", [], $request->get_param( 'search' ), $request );
		return rest_ensure_response( $providers );
	}

	/**
	 * List the items to choose from when the provider is chosen.
	 * This is done through code, so we expose a filter here.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function item( \WP_REST_Request $request ) {
		$item = apply_filters( "surecart/integrations/providers/{$request->get_param( 'provider' )}/item", $request['id'], $request );
		return rest_ensure_response( $item );
	}
}
