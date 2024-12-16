<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\CustomerNotificationProtocol;

/**
 * Handle requests through the REST API
 */
class CustomerNotificationProtocolController {
	/**
	 * Find.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		return CustomerNotificationProtocol::find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return CustomerNotificationProtocol::update( $request->get_json_params() );
	}
}
