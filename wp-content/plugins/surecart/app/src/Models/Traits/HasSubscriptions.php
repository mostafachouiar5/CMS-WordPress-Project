<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Subscription;

/**
 * If the model has an attached customer.
 */
trait HasSubscriptions {
	/**
	 * Set the subscriptions attribute
	 *
	 * @param  object $value Subscription data array.
	 * @return void
	 */
	public function setSubscriptionAttribute( $value ) {
		$this->setCollection( 'subscriptions', $value, Subscription::class );
	}

	/**
	 * Does this have subscriptions?
	 *
	 * @return boolean
	 */
	public function hasSubscriptions() {
		return count( $this->attributes['subscriptions'] ?? [] ) > 0;
	}
}
