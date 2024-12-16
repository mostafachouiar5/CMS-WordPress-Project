<?php

namespace SureCart\Models;

class ShippingMethod extends Model{
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'shipping_methods';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'shipping_method';
}
