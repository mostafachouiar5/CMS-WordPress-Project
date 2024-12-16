<?php

namespace SureCart\Models\Traits;

use SureCart\Models\ReferralItem;

/**
 * If the model has an attached customer.
 */
trait HasReferralItems {
	/**
	 * Set the referrals attribute
	 *
	 * @param object $value Array of referral objects.
	 *
	 * @return void
	 */
	public function setReferralItemsAttribute( $value ) {
		$this->setCollection( 'referral_items', $value, ReferralItem::class );
	}
}
