<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\BalanceTransaction;

/**
 * Handle Price requests through the REST API
 */
class BalanceTransactionsController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = BalanceTransaction::class;
}
