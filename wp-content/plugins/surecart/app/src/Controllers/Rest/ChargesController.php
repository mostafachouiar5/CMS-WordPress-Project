<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Charge;

/**
 * Handle Price requests through the REST API
 */
class ChargesController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Charge::class;

	/**
	 * Refund a charge
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function refund( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		$class  = new $this->class( [ 'id' => $request['id'] ] );
		$refund = $class->refund()->where( $request->get_query_params() )->with( [ 'charge' ] )->create( $request->get_json_params() );
		if ( is_wp_error( $refund ) ) {
			return $refund;
		}
		return $refund->charge;
	}
}
