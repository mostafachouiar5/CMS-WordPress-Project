<?php

namespace SureCart\Models;

/**
 * ShippingProtocol model
 */
class ShippingProtocol extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'shipping_protocol';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'shipping_protocol';

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = true;
}
