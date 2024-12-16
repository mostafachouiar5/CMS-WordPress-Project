<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\TaxZone;

/**
 * Handle coupon requests through the REST API
 */
class TaxZoneController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = TaxZone::class;
}
