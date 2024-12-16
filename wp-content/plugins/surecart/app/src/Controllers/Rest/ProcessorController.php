<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Processor;

/**
 * Handle Price requests through the REST API
 */
class ProcessorController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Processor::class;

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function paymentMethodTypes( \WP_REST_Request $request ) {
		$processor = $this->middleware( new $this->class( [ 'id' => $request['id'] ] ), $request );
		if ( is_wp_error( $processor ) ) {
			return $processor;
		}
		return $processor->where( $request->get_query_params() )->paymentMethodTypes();
	}
}
