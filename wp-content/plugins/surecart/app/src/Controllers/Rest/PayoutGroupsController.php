<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\PayoutGroup;

/**
 * Handle payout groups requests through the REST API
 */
class PayoutGroupsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = PayoutGroup::class;
}
