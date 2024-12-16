<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasPrice;

/**
 * Holds the data of the order bump.
 */
class Bump extends Model {
	use HasPrice;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'bumps';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'bump';
}
