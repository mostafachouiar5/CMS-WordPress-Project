<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\LineItem;

/**
 * Handle LineItem requests through the REST API
 */
class LineItemsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = LineItem::class;

	/**
	 * Upsell line item.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function upsell( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		if ( ! empty( $this->with ) ) {
			$model = $model->with( $this->with );
		}

		return $model->where( $request->get_query_params() )->upsell( $request->get_json_params() );
	}
}
