<?php

namespace SureCart\Controllers\Rest;

use SureCart\Controllers\Rest\RestController;
use SureCart\Models\VariantOption;

/**
 * Handle Variant Options request through the REST API
 */
class VariantOptionsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = VariantOption::class;
}
