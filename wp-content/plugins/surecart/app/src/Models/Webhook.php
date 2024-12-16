<?php

namespace SureCart\Models;

/**
 * Webhook Model.
 */
class Webhook extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'webhook_endpoints';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'webhook_endpoint';

	/**
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cachable = true;

	/**
	 * Clear cache when webhook endpoints are updated.
	 *
	 * @var string
	 */
	protected $cache_key = 'webhook_endpoints';
}
