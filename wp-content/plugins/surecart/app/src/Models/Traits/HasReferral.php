<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Referral;

/**
 * If the model has an attached customer.
 */
trait HasReferral {
	/**
	 * Set the affiliation attribute
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setAffiliationAttribute( $value ) {
		$this->setRelation( 'referral', $value, Referral::class );
	}
}
