<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Subscription;

/**
 * If the model has an attached customer.
 */
trait HasSubscription {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setSubscriptionAttribute( $value ) {
		$this->setRelation( 'subscription', $value, Subscription::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getSubscriptionIdAttribute() {
		return $this->getRelationId( 'subscription' );
	}
}
