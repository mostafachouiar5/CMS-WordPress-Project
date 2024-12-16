<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ManualPaymentMethod;

/**
 * Handle Price requests through the REST API
 */
class ManualPaymentMethodsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ManualPaymentMethod::class;
}
