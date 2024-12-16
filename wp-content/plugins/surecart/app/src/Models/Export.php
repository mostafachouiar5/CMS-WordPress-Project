<?php

namespace SureCart\Models;

/**
 * Export model.
 */
class Export extends Model {
	/**
	 * Rest API endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'exports';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'export';
}
