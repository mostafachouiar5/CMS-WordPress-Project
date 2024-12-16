<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Refund;

/**
 * If the model has an attached customer.
 */
trait HasRefund {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setRefundAttribute( $value ) {
		$this->setRelation( 'refund', $value, Refund::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getRefundIdAttribute() {
		return $this->getRelationId( 'refund' );
	}
}
