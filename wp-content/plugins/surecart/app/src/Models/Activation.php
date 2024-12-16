<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasLicense;

/**
 * Price model
 */
class Activation extends Model {
	use HasLicense;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'activations';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'activation';
}
