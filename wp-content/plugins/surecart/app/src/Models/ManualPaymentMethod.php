<?php
namespace SureCart\Models;

/**
 * Payment intent model.
 */
class ManualPaymentMethod extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'manual_payment_methods';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'manual_payment_method';

	/**
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cachable = true;

	/**
	 * Clear cache when products are updated.
	 *
	 * @var string
	 */
	protected $cache_key = 'manual_payment_methods';
}
