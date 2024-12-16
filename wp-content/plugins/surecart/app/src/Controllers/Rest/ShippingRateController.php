<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ShippingRate;

/**
 * Handle Shipping Rates requests through the REST API
 */
class ShippingRateController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ShippingRate::class;
}
