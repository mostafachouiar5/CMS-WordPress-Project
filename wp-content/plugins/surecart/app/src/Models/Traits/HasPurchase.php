<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Purchase;

/**
 * If the model has an attached customer.
 */
trait HasPurchase {
	/**
	 * Set the purchase attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setPurchaseAttribute( $value ) {
		$this->setRelation( 'purchase', $value, Purchase::class );
	}

	/**
	 * Get the purchase id attribute
	 *
	 * @return string
	 */
	public function getPurchaseIdAttribute() {
		return $this->getRelationId( 'purchase' );
	}
}
