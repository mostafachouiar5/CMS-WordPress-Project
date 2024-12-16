<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Export;

/**
 * Handle exports requests through the REST API
 */
class ExportsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Export::class;
}
