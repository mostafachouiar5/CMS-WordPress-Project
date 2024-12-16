<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ReturnReason;

/**
 * Handle Return Reasons requests through the REST API
 */
class ReturnReasonsController extends RestController {

	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ReturnReason::class;
}
