<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Subscription;

/**
 * Handle Price requests through the REST API
 */
class SubscriptionsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Subscription::class;

	/**
	 * Cancel a subscription.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function cancel( \WP_REST_Request $request ) {
		$class = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model = $this->middleware( $class, $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->cancel( $request['id'] );
	}

	/**
	 * Complete a subscription.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function complete( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->complete( $request['id'] );
	}

	/**
	 * Restore a subscription.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function restore( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->restore( $request['id'] );
	}

	/**
	 * Restore a subscription.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function preserve( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->preserve( $request['id'] );
	}


	/**
	 * Renew a subscription.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function renew( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->renew( $request['id'] );
	}

	/**
	 * Preview an upcoming invoice.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\SureCart\Models\Model|WP_Error
	 */
	public function upcomingPeriod( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class( $request['id'] ), $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->upcomingPeriod( $request->get_json_params() );
	}

	/**
	 * Pays off all remaining periods for a subscription.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function payOff( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->payOff( $request['id'] );
	}
}
