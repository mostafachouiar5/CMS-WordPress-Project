<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Coupon;

/**
 * If the model has an attached customer.
 */
trait HasCoupon {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setCouponAttribute( $value ) {
		$this->setRelation( 'coupon', $value, Coupon::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getCouponIdAttribute() {
		return $this->getRelationId( 'coupon' );
	}
}
