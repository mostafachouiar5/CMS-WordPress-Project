<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Upsell;

/**
 * Handle upsell requests through the REST API
 */
class UpsellsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Upsell::class;
}
