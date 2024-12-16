<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Coupon;

/**
 * Handle Coupon requests through the REST API
 */
class CouponsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Coupon::class;
}
