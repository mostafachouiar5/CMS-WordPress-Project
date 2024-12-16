<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Payout;

/**
 * If the model has an attached customer.
 */
trait HasPayout {
	/**
	 * Set the payout attribute
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setPayoutAttribute( $value ) {
		$this->setRelation( 'payout', $value, Payout::class );
	}
}
