<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Referral;

/**
 * If the model has an attached customer.
 */
trait HasReferrals {
	/**
	 * Set the referrals attribute
	 *
	 * @param object $value Array of referral objects.
	 *
	 * @return void
	 */
	public function setReferralsAttribute( $value ) {
		$this->setCollection( 'referrals', $value, Referral::class );
	}
}
