<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasLineItem;
use SureCart\Models\Traits\HasReferral;

/**
 * Referral Item model
 */
class ReferralItem extends Model {
	use HasLineItem, HasReferral;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'referral_items';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'referral_item';
}
