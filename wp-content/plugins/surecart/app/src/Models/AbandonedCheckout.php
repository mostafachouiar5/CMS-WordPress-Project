<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCheckout;
use SureCart\Models\Traits\HasCustomer;

/**
 * Order model
 */
class AbandonedCheckout extends Model {
	use HasCustomer;
	use HasCheckout;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'abandoned_checkouts';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'abandoned_checkout';

	/**
	 * Set the latest checkout session attribute
	 *
	 * @param  array $value Checkout session properties.
	 * @return void
	 */
	protected function setLatestRecoverableCheckoutAttribute( $value ) {
		$this->setRelation( 'recovered_checkout', $value, Checkout::class );
	}

	/**
	 * Get stats for the order.
	 *
	 * @param array $args Array of arguments for the statistics.
	 *
	 * @return \SureCart\Models\Statistic;
	 */
	protected function stats( $args = [] ) {
		$stat = new Statistic();
		return $stat->where( $args )->find( 'abandoned_checkouts' );
	}
}
