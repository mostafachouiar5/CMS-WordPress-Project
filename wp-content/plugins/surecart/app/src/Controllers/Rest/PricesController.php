<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Price;
use SureCart\Models\Product;

/**
 * Handle Price requests through the REST API
 */
class PricesController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Price::class;

	/**
	 * Run some middleware to run before request.
	 *
	 * @param \SureCart\Models\Model $class Model class instance.
	 * @param \WP_REST_Request       $request Request object.
	 *
	 * @return \SureCart\Models\Model
	 */
	protected function middleware( $class, \WP_REST_Request $request ) {
		// get the expands from the product for syncing.
		$expands = array_merge( [ 'product' ], array_map( fn( $expand ) => strpos( $expand, '.' ) !== false ? $expand : 'product.' . $expand, Product::getSyncExpands() ) );
		// If we are updating or creating, always return the product for syncing.
		if ( in_array( $request->get_method(), [ 'POST', 'PUT', 'PATCH', 'DELETE' ] ) ) {
			$class->with( array_unique( array_filter( array_merge( $expands, $request['expand'] ?? [] ) ) ) );
		}
		return parent::middleware( $class, $request );
	}
}
