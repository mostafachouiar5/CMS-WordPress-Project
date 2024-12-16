<?php

namespace SureCart\Models;

use SureCart\Models\Coupon;
use SureCart\Models\Traits\HasCoupon;

/**
 * Price model
 */
class Promotion extends Model {
	use HasCoupon;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'promotions';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'promotion';

	/**
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cachable = true;

	/**
	 * Clear cache when coupons are updated.
	 *
	 * @var string
	 */
	protected $cache_key = 'coupons';
}
