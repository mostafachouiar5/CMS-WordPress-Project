<?php

namespace SureCart\Models;

/**
 * Order model
 */
class PortalSession extends Order {

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'portal_sessions';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'portal_session';
}
