<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\AffiliationProtocol;

/**
 * Handle coupon requests through the REST API
 */
class AffiliationProtocolController {
	/**
	 * Find Affiliation Protocol.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		return AffiliationProtocol::with( [ 'commission_structure' ] )->find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return AffiliationProtocol::update( $request->get_json_params() )
			->with( [ 'commission_structure' ] )
			->find();
	}
}
