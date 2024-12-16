<?php

namespace SureCart\Models;

/**
 * Price model
 */
class OrderProtocol extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'order_protocol';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'order_protocol';

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = true;
}
