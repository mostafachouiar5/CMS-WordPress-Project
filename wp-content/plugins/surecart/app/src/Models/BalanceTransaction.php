<?php

namespace SureCart\Models;

/**
 * Holds balance transaction data
 */
class BalanceTransaction extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'balance_transactions';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'balance_transaction';
}
