<?php

namespace SureCart\Models;

/**
 * Variant Value model.
 */
class VariantValue extends Model {
	/**
	 * Rest API endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'variant_values';

	/**
	 * Object name.
	 *
	 * @var string
	 */
	protected $object_name = 'variant_value';

	/**
	 * Set the VariantOption attribute
	 *
	 * @param  string $value VariantOption properties.
	 * @return void
	 */
	public function setVariantOptionAttribute( $value ) {
		$this->setRelation( 'variant_option', $value, VariantOption::class );
	}
}
