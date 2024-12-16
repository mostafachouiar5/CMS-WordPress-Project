<?php

namespace SureCart\Models;

/**
 * Holds the data of the current account.
 */
class Account extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'account';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'account';

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = true;
}
