<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ProductGroup;

/**
 * Handle Product requests through the REST API
 */
class ProductGroupsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ProductGroup::class;
}
