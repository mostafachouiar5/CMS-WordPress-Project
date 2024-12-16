<?php

namespace SureCart\Models;

/**
 * Fulfillment model.
 */
class Fulfillment extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'fulfillments';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'fulfillment';

	/**
	 * Set the prices attribute.
	 *
	 * @param  object $value Array of price objects.
	 * @return void
	 */
	public function setFulfillmentItemsAttribute( $value ) {
		$this->setCollection( 'fulfillment_items', $value, FulfillmentItem::class );
	}
}
