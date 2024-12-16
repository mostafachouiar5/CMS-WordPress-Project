<?php
namespace SureCart\Models;

use SureCart\Models\DatabaseModel;

/**
 * The integration model.
 */
class VariantOptionValue extends DatabaseModel {
	/**
	 * The integrations table name.
	 *
	 * @var string
	 */
	protected $table_name = 'surecart_variant_option_values';

	/**
	 * The object name
	 *
	 * @var string
	 */
	protected $object_name = 'variant_option_values';

	/**
	 * Fillable items.
	 *
	 * @var array
	 */
	protected $fillable = [ 'id', 'value', 'name', 'post_id', 'product_id', 'account_id', 'updated_at', 'created_at' ];

	/**
	 * Create a new model
	 *
	 * @param array $attributes Attributes to create.
	 *
	 * @return $this|false
	 */
	protected function create( $attributes = [] ) {
		$attributes['account_id'] = \SureCart::account()->id;
		return parent::create( $attributes );
	}

	/**
	 * Update a model
	 *
	 * @param array $attributes Attributes to create.
	 *
	 * @return $this|false
	 */
	protected function update( $attributes = [] ) {
		$attributes['account_id'] = \SureCart::account()->id;
		return parent::update( $attributes );
	}
}
