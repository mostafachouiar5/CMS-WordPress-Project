<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Promotion;

/**
 * Handle Promotion requests through the REST API
 */
class PromotionsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Promotion::class;
}
