<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\CancellationReason;

/**
 * Handle coupon requests through the REST API
 */
class CancellationReasonsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = CancellationReason::class;
}
