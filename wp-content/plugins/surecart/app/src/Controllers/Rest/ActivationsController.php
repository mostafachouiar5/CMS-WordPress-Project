<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Activation;

/**
 * Handle Activation requests through the REST API
 */
class ActivationsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Activation::class;
}
