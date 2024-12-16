<?php

namespace SureCart\Models\Traits;

use SureCart\Models\PaymentIntent;

/**
 * If the model has an attached customer.
 */
trait HasPaymentIntent {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setPaymentIntentAttribute( $value ) {
		$this->setRelation( 'payment_intent', $value, PaymentIntent::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getPaymentIntentIdAttribute() {
		return $this->getRelationId( 'payment_intent' );
	}
}
