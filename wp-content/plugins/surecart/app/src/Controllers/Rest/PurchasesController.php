<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Purchase;

/**
 * Handle Price requests through the REST API
 */
class PurchasesController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Purchase::class;

	/**
	 * Revoke a purchase.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function revoke( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $this->class::where( $request->get_query_params() )->revoke( $request['id'] );
	}

	/**
	 * Invoke (un-revoke) a purchase.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function invoke( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $this->class::where( $request->get_query_params() )->invoke( $request['id'] );
	}
}
