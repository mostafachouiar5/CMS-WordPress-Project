<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\UpsellFunnel;

/**
 * Handle upsell requests through the REST API
 */
class UpsellFunnelsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = UpsellFunnel::class;
}
