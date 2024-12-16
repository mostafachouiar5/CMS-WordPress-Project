<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ShippingMethod;

/**
 * Handle Shipping Methods requests through the REST API
 */
class ShippingMethodController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ShippingMethod::class;
}
