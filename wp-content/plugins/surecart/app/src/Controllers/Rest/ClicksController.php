<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Click;

/**
 * Handle clicks requests through the REST API
 */
class ClicksController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Click::class;
}
