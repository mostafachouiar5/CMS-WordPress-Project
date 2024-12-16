<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Checkout;
use SureCart\WordPress\Users\CustomerLinkService;

/**
 * Handle price requests through the REST API
 */
class DraftCheckoutsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Checkout::class;

	/**
	 * Manually pay an order.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \SureCart\Models\Checkout|\WP_Error
	 */
	public function manuallyPay( \WP_REST_Request $request ) {
		$checkout = $this->middleware( new $this->class( $request['id'] ), $request );
		if ( is_wp_error( $checkout ) ) {
			return $checkout;
		}

		$paid = $checkout->where( $request->get_query_params() )->with(
			[
				'purchases', // Important: we need to make sure we expand the purchase to provide access.
			]
		)->manuallyPay();

		// purchase created.
		if ( ! empty( $paid->purchases->data ) ) {
			foreach ( $paid->purchases->data as $purchase ) {
				if ( empty( $purchase->revoked ) ) {
					// broadcast the webhook.
					do_action( 'surecart/purchase_created', $purchase );
				}
			}
		}

		return $paid;
	}

	/**
	 * Finalize an order.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \SureCart\Models\Checkout|\WP_Error
	 */
	public function finalize( \WP_REST_Request $request ) {
		$checkout = new $this->class( [ 'id' => $request['id'] ] );
		$finalized =  $checkout->where( $request->get_query_params() )->finalize( $request->get_body_params() );

		// handle error.
		if ( is_wp_error($finalized)) {
			return $finalized;
		}

		// not paid, don't continue.
		if ( !in_array( $finalized->status, ['paid'] )) {
			return $finalized;
		}

		// fetch the checkout with purchases.
		$checkout = $checkout->where(array_merge(
			$request->get_query_params(),
			[ 'refresh_status' => true ] // Important: Do not remove. This will force syncing with the processor.
		))->with(
			[
				'purchases', // Important: we need to make sure we expand the purchase to provide access.
				'customer', // Important: we need to use this to create the WP User with the same info.
			]
		)->find( $request['id'] );

		// bail if error.
		if ( is_wp_error( $checkout ) ) {
			return $checkout;
		}

		// purchase created.
		if ( ! empty( $checkout->purchases->data ) ) {
			foreach ( $checkout->purchases->data as $purchase ) {
				if ( empty( $purchase->revoked ) ) {
					try {
						// broadcast the webhook.
						do_action( 'surecart/purchase_created', $purchase );
					} catch( \Exception $e) {
						error_log( $e->getMessage() );
					}
				}
			}
		}

		// the order is confirmed.
		do_action( 'surecart/checkout_confirmed', $checkout, $request );

		// return the order.
		return $checkout;
	}

	/**
	 * Link the customer id to the order.
	 *
	 * @param \SureCart\Models\Checkout $checkout Checkout model.
	 * @return \WP_User|\WP_Error
	 */
	public function linkCustomerId( $checkout ) {
		// get transient.
		$password_hash = get_transient( 'sc_checkout_password_hash_' . $checkout->id );
		// delete transient.
		delete_transient( 'sc_checkout_password_hash_' . $checkout->id );
		// link customer.
		$service = new CustomerLinkService( $checkout, $password_hash );
		return $service->link();
	}
}
