<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Checkout;

/**
 * If the model has an attached customer.
 */
trait HasCheckout {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setCheckoutAttribute( $value ) {
		$this->setRelation( 'checkout', $value, Checkout::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getCheckoutIdAttribute() {
		return $this->getRelationId( 'checkout' );
	}
}
