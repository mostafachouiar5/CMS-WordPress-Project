<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\OrderProtocol;

/**
 * Handle coupon requests through the REST API
 */
class OrderProtocolController {
	/**
	 * Find model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		return OrderProtocol::find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return OrderProtocol::update( $request->get_json_params() );
	}
}
