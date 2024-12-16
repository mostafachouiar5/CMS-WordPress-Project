<?php

namespace SureCart\Models\Traits;

use SureCart\Models\PaymentMethod;

/**
 * If the model has an attached customer.
 */
trait HasPaymentMethod {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setPaymentMethodAttribute( $value ) {
		$this->setRelation( 'payment_method', $value, PaymentMethod::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getPaymentMethodIdAttribute() {
		return $this->getRelationId( 'payment_method' );
	}
}
