<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Affiliation;

/**
 * Handle Affiliations requests through the REST API
 */
class AffiliationsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Affiliation::class;

	/**
	 * Run some middleware to run before request.
	 *
	 * @param \SureCart\Models\Model $class Model class instance.
	 * @param \WP_REST_Request       $request Request object.
	 *
	 * @return \SureCart\Models\Model
	 */
	protected function middleware( $class, \WP_REST_Request $request ) {
		// if we are in edit context, we want to fetch the commission_structure.
		if ( 'edit' === $request->get_param( 'context' ) || in_array( $request->get_method(), [ 'POST', 'PUT', 'PATCH', 'DELETE' ] ) ) {
			$class->with( [ 'commission_structure' ] );
		}
		return parent::middleware( $class, $request );
	}

	/**
	 * Activate an affiliation.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function activate( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->activate( $request['id'] );
	}

	/**
	 * Deactivate an affiliation.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function deactivate( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->where( $request->get_query_params() )->deactivate( $request['id'] );
	}
}
