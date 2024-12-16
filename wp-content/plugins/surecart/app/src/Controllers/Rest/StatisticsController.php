<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\AbandonedCheckout;
use SureCart\Models\CancellationAct;
use SureCart\Models\CancellationReason;
use SureCart\Models\Order;
use SureCart\Models\Subscription;

/**
 * Handle Statistic requests through the REST API
 */
class StatisticsController {
	/**
	 * Map a string to php class
	 *
	 * @var array
	 */
	protected $models = [
		'orders'               => Order::class,
		'abandoned_checkouts'  => AbandonedCheckout::class,
		'cancellation_reasons' => CancellationReason::class,
		'cancellation_acts'    => CancellationAct::class,
		'subscriptions'        => Subscription::class,
	];

	/**
	 * Find model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function find( \WP_REST_Request $request ) {
		return $this->models[ $request['id'] ]::stats( $request->get_query_params() );
	}
}
