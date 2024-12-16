<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\CancellationAct;

/**
 * Handle coupon requests through the REST API
 */
class CancellationActsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = CancellationAct::class;
}
