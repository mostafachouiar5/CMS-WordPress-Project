<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Price;

/**
 * If the model has an attached customer.
 */
trait HasPrice {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setPriceAttribute( $value ) {
		$this->setRelation( 'price', $value, Price::class );
	}

	/**
	 * Get the price id attribute
	 *
	 * @return string
	 */
	public function getPriceIdAttribute() {
		return $this->getRelationId( 'price' );
	}
}
