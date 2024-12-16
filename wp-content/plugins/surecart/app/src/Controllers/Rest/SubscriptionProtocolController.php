<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\SubscriptionProtocol;

/**
 * Handle Price requests through the REST API
 */
class SubscriptionProtocolController {
	/**
	 * Find model.
	 *
	 * @return Model
	 */
	public function find( \WP_REST_Request $request ) {
		return SubscriptionProtocol::with( [ 'preservation_coupon' ] )->find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return SubscriptionProtocol::update( $request->get_json_params() );
	}
}
