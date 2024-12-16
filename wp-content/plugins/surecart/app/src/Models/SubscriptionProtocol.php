<?php

namespace SureCart\Models;

/**
 * Holds the data of the current account.
 */
class SubscriptionProtocol extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'subscription_protocol';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'subscription_protocol';

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = true;
}
