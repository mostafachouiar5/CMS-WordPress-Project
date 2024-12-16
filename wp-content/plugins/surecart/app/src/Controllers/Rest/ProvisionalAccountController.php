<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Account;
use SureCart\Models\ProvisionalAccount;

/**
 * Handle Provisional account requests through the REST API
 */
class ProvisionalAccountController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ProvisionalAccount::class;

	/**
	 * When indexing, fetch the account.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function index( \WP_REST_Request $request ) {
		return Account::find();
	}
}
