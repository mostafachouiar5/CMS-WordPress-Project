<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\AbandonedCheckout;

/**
 * Handle price requests through the REST API
 */
class AbandonedCheckoutsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = AbandonedCheckout::class;
}
