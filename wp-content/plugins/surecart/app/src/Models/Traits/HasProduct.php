<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Product;

/**
 * If the model has an attached customer.
 */
trait HasProduct {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setProductAttribute( $value ) {
		$this->setRelation( 'product', $value, Product::class );
	}

	/**
	 * Get the product id attribute
	 *
	 * @return string
	 */
	public function getProductIdAttribute() {
		return $this->getRelationId( 'product' );
	}
}
