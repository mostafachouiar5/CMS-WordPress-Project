<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Period;

/**
 * Handle Price requests through the REST API
 */
class PeriodsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Period::class;

	/**
	 * Retry a payment
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function retryPayment( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->retryPayment( $request['id'] );
	}
}
