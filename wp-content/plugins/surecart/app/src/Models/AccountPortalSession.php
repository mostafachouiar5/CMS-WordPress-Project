<?php

namespace SureCart\Models;

/**
 * Order model
 */
class AccountPortalSession extends Order {

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'account_portal_sessions';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'account_portal_session';
}
