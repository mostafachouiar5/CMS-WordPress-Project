<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Purchase;

/**
 * If the model has an attached customer.
 */
trait HasPurchases {
	/**
	 * Set the subscriptions attribute
	 *
	 * @param  object $value Subscription data array.
	 * @return void
	 */
	public function setPurchasesAttribute( $value ) {
		$this->setCollection( 'purchases', $value, Purchase::class );
	}

	/**
	 * Does this have subscriptions?
	 *
	 * @return boolean
	 */
	public function hasPurchases() {
		return count( $this->attributes['purchases'] ?? [] ) > 0;
	}
}
