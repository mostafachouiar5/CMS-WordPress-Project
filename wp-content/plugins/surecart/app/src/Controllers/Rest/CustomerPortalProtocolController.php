<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\CustomerPortalProtocol;

/**
 * Handle Price requests through the REST API
 */
class CustomerPortalProtocolController {
	/**
	 * Find model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 * @return Model
	 */
	public function find( \WP_REST_Request $request ) {
		return CustomerPortalProtocol::find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return CustomerPortalProtocol::update( $request->get_json_params() );
	}
}
