<?php

namespace SureCart\Models;

/**
 * Cancellation Reason Model
 */
class CancellationReason extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'cancellation_reasons';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'cancellation_reason';

	/**
	 * Get stats for the order.
	 *
	 * @param array $args Array of arguments for the statistics.
	 *
	 * @return \SureCart\Models\Statistic;
	 */
	protected function stats( $args = [] ) {
		$stat = new Statistic();
		return $stat->where( $args )->find( 'cancellation_reasons' );
	}
}
