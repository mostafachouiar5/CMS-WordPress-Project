<?php

namespace SureCart\Integrations\AffiliateWP;

use SureCart\Models\Purchase;
use SureCart\Support\Currency;

/**
 * Custom Integration Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AffiliateWPRecurringIntegration
 */
class AffiliateWPRecurringIntegration extends \Affiliate_WP_Recurring_Base {
	/**
	 * The context for referrals. This refers to the integration that is being used.
	 *
	 * @access  public
	 * @var string
	 */
	public $context = 'surecart';

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   2.0
	 */
	public function init() {
		// Add referral when subscription renewed.
		add_action( 'surecart/subscription_renewed', [ $this, 'renewedSubscription' ], 10, 1 );
	}

	/**
	 * Records a recurring referral when a subscription renews
	 *
	 * @param $subscription Subscription object.
	 */
	public function renewedSubscription( $subscription ) {
		// Check if recurring referral is active
		if ( ! class_exists( 'AffiliateWP_Recurring_Referrals' ) ) {
			affiliate_wp()->utils->log( 'Recurring referral not applied.' );
			return;
		}

		// Get details purchase information
		$purchase = Purchase::with( [ 'initial_order', 'subscription', 'subscription.current_period', 'period.checkout', 'product' ] )->find( $subscription->purchase );

		// Get the order reference.
		$reference = $purchase->initial_order ?? null;

		// We must have an order id.
		if ( ! $reference->id ) {
			affiliate_wp()->utils->log( 'Draft referral creation failed. No order attached.' );
			return;
		}

		// Get the parent referral
		$parent_referral = affiliate_wp()->referrals->get_by( 'reference', $reference->id, $this->context );

		// This signup wasn't referred or is the very first payment of a referred subscription
		if ( ! $parent_referral || ! is_object( $parent_referral ) || 'rejected' == $parent_referral->status ) {
			affiliate_wp()->utils->log( 'Recurring Referrals: No referral found or referral is rejected.' );
			return false;
		}

		$amount_due    = $purchase->subscription->current_period->checkout->amount_due;
		$currency      = $reference->currency;
		$description   = $purchase->product->name;

		if ( Currency::isZeroDecimal( $currency ) ) {
			$amount = $amount_due;
		} else {
			$amount = round( $amount_due / 100, 2 );
		}

		// Calculate referral amount
		$referral_amount = $this->calc_referral_amount( $amount, $reference, $parent_referral->referral_id );

		// Create referral for subscription.
		$referral_id = $this->insert_referral(
			[
				'amount'       => $referral_amount,
				'reference'    => $reference,
				'description'  => $description,
				'affiliate_id' => $parent_referral->affiliate_id,
				'context'      => $this->context,
			]
		);

		if ( ! $referral_id ) {
			affiliate_wp()->utils->log( 'Draft referral creation failed.' );
			return;
		}

		// Complete referral
		if ( $this->complete_referral( $referral_id ) ) {
			affiliate_wp()->utils->log( 'Referral completed successfully during insert_referral()' );
			return;
		}

	}

}
