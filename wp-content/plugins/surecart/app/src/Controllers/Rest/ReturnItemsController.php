<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ReturnItem;

/**
 * Handle Return Items requests through the REST API
 */
class ReturnItemsController extends RestController {

	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ReturnItem::class;
}
