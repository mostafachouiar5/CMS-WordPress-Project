<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ShippingZone;

/**
 * Handle Shipping Zones requests through the REST API
 */
class ShippingZoneController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ShippingZone::class;
}
