<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCustomer;
use SureCart\Models\Traits\HasOrder;
use SureCart\Models\Traits\HasPaymentMethod;
use SureCart\Models\Traits\HasSubscription;

/**
 * Subscription model
 */
class Charge extends Model {
	use HasCustomer, HasOrder, HasSubscription, HasPaymentMethod;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'charges';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'charge';

	/**
	 * Refund this specific charge
	 *
	 * @return \SureCart\Models\Refund
	 */
	protected function refund() {
		return new Refund( [ 'charge' => $this->id ] );
	}
}
