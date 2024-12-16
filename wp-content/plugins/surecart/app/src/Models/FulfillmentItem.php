<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasLineItem;

/**
 * Fulfillment model.
 */
class FulfillmentItem extends Model {
	use HasLineItem;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'fulfillment_items';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'fulfillment_item';
}
