<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Bump;

/**
 * Handle coupon requests through the REST API
 */
class BumpsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Bump::class;
}
