<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\PaymentIntent;

/**
 * Handle Price requests through the REST API
 */
class PaymentIntentsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = PaymentIntent::class;

	/**
	 * Detach a payment method
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function capture( \WP_REST_Request $request ) {
		$intent = new $this->class( [ 'id' => $request['id'] ] );
		return $intent->where( $request->get_query_params() )
			->capture( $request->get_json_params() );
	}
}
