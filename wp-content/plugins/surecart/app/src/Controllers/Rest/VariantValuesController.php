<?php

namespace SureCart\Controllers\Rest;

use SureCart\Controllers\Rest\RestController;
use SureCart\Models\VariantValue;

/**
 * Handle Variant Values request through the REST API
 */
class VariantValuesController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = VariantValue::class;
}
