<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Order;
use SureCart\Models\Form;
use SureCart\Models\User;
use SureCart\WordPress\Users\CustomerLinkService;

/**
 * Handle price requests through the REST API
 */
class OrderController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Order::class;
}
