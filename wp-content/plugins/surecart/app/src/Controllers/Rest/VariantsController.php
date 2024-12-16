<?php

namespace SureCart\Controllers\Rest;

use SureCart\Controllers\Rest\RestController;
use SureCart\Models\Variant;

/**
 * Handle Variants request through the REST API
 */
class VariantsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Variant::class;
}
