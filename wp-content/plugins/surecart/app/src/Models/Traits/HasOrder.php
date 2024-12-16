<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Order;

/**
 * If the model has an attached customer.
 */
trait HasOrder {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setOrderAttribute( $value ) {
		$this->setRelation( 'order', $value, Order::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getOrderIdAttribute() {
		return $this->getRelationId( 'order' );
	}
}
