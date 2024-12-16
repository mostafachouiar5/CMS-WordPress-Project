<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Fulfillment;

/**
 * Handle Fulfillment requests through the REST API
 */
class FulfillmentsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Fulfillment::class;
}
