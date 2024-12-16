<?php

namespace SureCart\Controllers\Rest;

/**
 * Rest controller base class.
 */
abstract class RestController {
	/**
	 * Always fetch with these subcollections.
	 *
	 * @var array
	 */
	protected $with = [];

	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = '';

	/**
	 * Run some middleware to run before request.
	 *
	 * @param \SureCart\Models\Model $class Model class instance.
	 * @param \WP_REST_Request       $request Request object.
	 *
	 * @return \SureCart\Models\Model
	 */
	protected function middleware( $class, \WP_REST_Request $request ) {
		return apply_filters( 'surecart/request/model', $class, $request );
	}

	/**
	 * Create model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function create( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		if ( ! empty( $this->with ) ) {
			$model = $model->with( $this->with );
		}

		return $model->where( $request->get_query_params() )->create( $request->get_json_params() );
	}

	/**
	 * Index model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function index( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		if ( ! empty( $this->with ) ) {
			$model = $model->with( $this->with );
		}

		$items = $model->where( $request->get_params() )->paginate(
			[
				'per_page' => $request->get_param( 'per_page' ),
				'page'     => $request->get_param( 'page' ),
			]
		);

		// check for error.
		if ( is_wp_error( $items ) ) {
			return $items;
		}

		$response = rest_ensure_response( $items->data );
		$response->header( 'X-WP-Total', (int) ( $items->pagination->count ?? 0 ) );
		$max_pages = ceil( ( $items->pagination->count ?? 0 ) / ( $items->pagination->limit ?? 1 ) );
		$response->header( 'X-WP-TotalPages', (int) $max_pages );

		return $response;
	}

	/**
	 * Find model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \SureCart\Models\Model|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		if ( ! empty( $this->with ) ) {
			$model = $model->with( $this->with );
		}

		return $model->where( $request->get_query_params() )->find( $request['id'] );
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class( $request['id'] ), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		if ( ! empty( $this->with ) ) {
			$model = $model->with( $this->with );
		}

		return $model->where( $request->get_query_params() )->update( $request->get_json_params() );
	}

	/**
	 * Delete model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function delete( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		if ( ! empty( $this->with ) ) {
			$model = $model->with( $this->with );
		}

		return $model->delete( $request['id'] );
	}
}
