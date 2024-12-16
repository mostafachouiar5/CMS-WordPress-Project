<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Discount;

trait HasDiscount {
	/**
	 * Set the discount attribute.
	 *
	 * @param object $value Discount object.
	 *
	 * @return void
	 */
	public function setDiscountAttribute( $value ) {
		if ( is_string( $value ) || empty( $value ) ) {
			$this->attributes['discount'] = $value;
			return $this;
		}

		$this->setRelation( 'discount', $value, Discount::class );
	}
}
