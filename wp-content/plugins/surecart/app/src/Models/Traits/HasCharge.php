<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Charge;

/**
 * If the model has an attached customer.
 */
trait HasCharge {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setChargeAttribute( $value ) {
		$this->setRelation( 'charge', $value, Charge::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getChargeIdAttribute() {
		return $this->getRelationId( 'charge' );
	}
}
