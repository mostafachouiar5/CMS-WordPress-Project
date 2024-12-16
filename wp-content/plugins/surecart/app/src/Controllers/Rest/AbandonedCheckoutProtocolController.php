<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\AbandonedCheckoutProtocol;

/**
 * Handle coupon requests through the REST API
 */
class AbandonedCheckoutProtocolController {
	/**
	 * Find model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		return AbandonedCheckoutProtocol::with( [ 'coupon' ] )->find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return AbandonedCheckoutProtocol::with( [ 'coupon' ] )->update( $request->get_json_params() );
	}
}
