<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\License;

/**
 * Handle License requests through the REST API
 */
class LicensesController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = License::class;
}
