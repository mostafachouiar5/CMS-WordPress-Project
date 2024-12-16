<?php

namespace SureCart\Models;

/**
 * ShippingRate model
 */
class ShippingRate extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'shipping_rates';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'shipping_rate';
}
