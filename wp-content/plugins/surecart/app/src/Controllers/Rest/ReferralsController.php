<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Referral;

/**
 * Handle referrals requests through the REST API
 */
class ReferralsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Referral::class;

	/**
	 * Approve a referral.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function approve( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->approve( $request['id'] );
	}

	/**
	 * Deny a referral
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function deny( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->deny( $request['id'] );
	}

	/**
	 * Make a referral as in review
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function make_reviewing( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->make_reviewing( $request['id'] );
	}
}
