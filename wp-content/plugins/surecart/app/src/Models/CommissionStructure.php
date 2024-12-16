<?php

namespace SureCart\Models;

use SureCart\Support\Currency;

/**
 * CommissionStructure modal.
 */
class CommissionStructure extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'commission_structures';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'commission_structure';

	/**
	 * Get commission amount attribute.
	 *
	 * @return string
	 */
	public function getCommissionAmountAttribute() {
		if ( empty( $this->amount_commission ) && empty( $this->percent_commission ) ) {
			return '-';
		}

		return $this->amount_commission ?
			Currency::format( $this->amount_commission, \SureCart::account()->currency ?? 'usd' )
			: $this->percent_commission . '%';
	}

	/**
	 * Get subscription commission attribute.
	 *
	 * @return string|null
	 */
	public function getSubscriptionCommissionAttribute() {
		if ( $this->recurring_commissions_enabled ) {
			if ( empty( $this->recurring_commission_days ) ) {
				return '∞';
			}
			// translators: %d is the number of days.
			return sprintf( _n( '%d Day', '%d Days', $this->recurring_commission_days, 'surecart' ), $this->recurring_commission_days );
		}

		return null;
	}

	/**
	 * Get lifetime commission attribute.
	 *
	 * @return string|null
	 */
	public function getLifetimeCommissionAttribute() {
		if ( $this->repeat_customer_commissions_enabled ) {
			if ( empty( $this->repeat_customer_commission_days ) ) {
				return '∞';
			}
			// translators: %d is the number of days.
			return sprintf( _n( '%d Day', '%d Days', $this->repeat_customer_commission_days, 'surecart' ), $this->repeat_customer_commission_days );
		}

		return null;
	}
}
