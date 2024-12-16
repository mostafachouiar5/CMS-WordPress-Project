<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Invoice;

/**
 * Handle Invoice requests through the REST API
 */
class InvoicesController extends RestController {
	/**
	 * Always fetch with these subcollections.
	 *
	 * @var array
	 */
	protected $with = [
		'checkout',
		'checkout.line_items',
		'line_item.price',
		'line_item.fees',
		'line_item.variant',
		'price.product',
		'product.featured_product_media',
		'product_media.media',
		'checkout.customer',
		'customer.shipping_address',
		'customer.billing_address',
		'checkout.payment_intent',
		'checkout.discount',
		'discount.promotion',
		'discount.coupon',
		'checkout.shipping_address',
		'checkout.billing_address',
		'checkout.shipping_choices',
		'shipping_choices.shipping_method',
		'payment_method.card',
		'checkout.tax_identifier',
		'checkout.order',
		'checkout.payment_method',
		'checkout.manual_payment_method',
	];

	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Invoice::class;

	/**
	 * Make draft invoice.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return Invoice|\WP_Error
	 */
	public function makeDraft( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->makeDraft( $request['id'] );
	}

	/**
	 * Open an invoice.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return Invoice|\WP_Error
	 */
	public function open( \WP_REST_Request $request ) {
		$class     = new $this->class( $request->get_json_params() );
		$class->id = $request['id'];
		$model     = $this->middleware( $class, $request );

		if ( is_wp_error( $model ) ) {
			return $model;
		}

		return $model->where( $request->get_query_params() )->open( $request['id'] );
	}
}
