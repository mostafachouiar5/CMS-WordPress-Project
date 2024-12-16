<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCustomer;

/**
 * Price model
 */
class CustomerLink extends Model {
	use HasCustomer;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'customer_links';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'customer_link';
}
