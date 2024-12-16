<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ReturnRequest;

/**
 * Handle Return Requests requests through the REST API
 */
class ReturnRequestsController extends RestController {

	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ReturnRequest::class;

	/**
	 * Open a return request.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function open( \WP_REST_Request $request ) {
		$class = new $this->class( $request->get_json_params() );
		$model = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->open( $request['id'] );
	}

	/**
	 * Complete a return request.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function complete( \WP_REST_Request $request ) {
		$class = new $this->class( $request->get_json_params() );
		$model = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->complete( $request['id'] );
	}
}
