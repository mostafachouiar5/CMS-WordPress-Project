<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ReferralItem;

/**
 * Handle referral items requests through the REST API
 */
class ReferralItemsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ReferralItem::class;
}
