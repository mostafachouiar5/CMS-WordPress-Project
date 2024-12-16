<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Account;

/**
 * Handle coupon requests through the REST API
 */
class AccountController {
	/**
	 * Find account.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		return Account::find();
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		return Account::update( $request->get_json_params() );
	}
}
