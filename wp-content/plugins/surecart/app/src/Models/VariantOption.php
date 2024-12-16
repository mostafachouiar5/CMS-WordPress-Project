<?php

namespace SureCart\Models;

/**
 * Variant Option model.
 */
class VariantOption extends Model {
	/**
	 * Rest API endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'variant_options';

	/**
	 * Object name.
	 *
	 * @var string
	 */
	protected $object_name = 'variant_option';

	/**
	 * Set the product attribute.
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setProductAttribute( $value ) {
		$this->setRelation( 'product', $value, Product::class );
	}
}
