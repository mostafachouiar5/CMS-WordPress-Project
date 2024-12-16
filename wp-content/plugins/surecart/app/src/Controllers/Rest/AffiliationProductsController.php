<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\AffiliationProduct;

/**
 * Handle Affiliation Products through the REST API
 */
class AffiliationProductsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = AffiliationProduct::class;
}
