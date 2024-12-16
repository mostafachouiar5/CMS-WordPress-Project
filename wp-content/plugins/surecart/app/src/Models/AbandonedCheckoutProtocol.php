<?php

namespace SureCart\Models;

/**
 * Order model
 */
class AbandonedCheckoutProtocol extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'abandoned_checkout_protocol';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'abandoned_checkout_protocol';

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = true;
}
