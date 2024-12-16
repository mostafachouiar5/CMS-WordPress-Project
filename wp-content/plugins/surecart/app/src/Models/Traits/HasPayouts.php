<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Payout;

/**
 * If the model has an attached customer.
 */
trait HasPayouts {
	/**
	 * Set the payouts attribute
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setPayoutsAttribute( $value ) {
		$this->setCollection( 'payouts', $value, Payout::class );
	}
}
