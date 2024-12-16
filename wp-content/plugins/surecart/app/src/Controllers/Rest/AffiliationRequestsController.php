<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\AffiliationRequest;

/**
 * Handle Affiliation Requests through the REST API
 */
class AffiliationRequestsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = AffiliationRequest::class;

	/**
	 * Approve an affiliation request.
	 *
	 * @param \WP_REST_Request $request  Request object.
	 *
	 * @return \SureCart\Models\AffiliationRequest|\WP_Error
	 */
	public function approve( \WP_REST_Request $request ) {
		return AffiliationRequest::approve( $request['id'] );
	}

	/**
	 * Deny an affiliation request.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return \SureCart\Models\AffiliationRequest|\WP_Error
	 */
	public function deny( \WP_REST_Request $request ) {
		return AffiliationRequest::deny( $request['id'] );
	}
}
