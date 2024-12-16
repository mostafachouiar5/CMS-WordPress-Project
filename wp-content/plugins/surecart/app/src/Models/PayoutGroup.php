<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasPayouts;

/**
 * Payout Group model
 */
class PayoutGroup extends Model {
	use HasPayouts;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'payout_groups';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'payout_group';
}
