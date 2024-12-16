<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCheckout;

/**
 * Order model
 */
class Order extends Model {
	use HasCheckout;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'orders';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'order';

	/**
	 * Get stats for the order.
	 *
	 * @param array $args Array of arguments for the statistics.
	 *
	 * @return \SureCart\Models\Statistic;
	 */
	protected function stats( $args = [] ) {
		$stat = new Statistic();
		return $stat->where( $args )->find( 'orders' );
	}
}
