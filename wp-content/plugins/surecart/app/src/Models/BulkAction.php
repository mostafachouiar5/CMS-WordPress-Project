<?php

namespace SureCart\Models;

/**
 * BulkAction model
 */
class BulkAction extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'bulk_actions';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'bulk_action';
}
