<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\PaymentMethod;

/**
 * Handle Price requests through the REST API
 */
class PaymentMethodsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = PaymentMethod::class;

	/**
	 * Detach a payment method
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function detach( \WP_REST_Request $request ) {
		$payment_method = new $this->class( [ 'id' => $request['id'] ] );
		return $payment_method->where( $request->get_query_params() )
			->detach( $request->get_json_params() );
	}
	/**
	 * Delete a payment method
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function delete( \WP_REST_Request $request ) {
		return $this->detach( $request );
	}
}
