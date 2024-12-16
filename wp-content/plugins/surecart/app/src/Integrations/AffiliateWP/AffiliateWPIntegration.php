<?php

namespace SureCart\Integrations\AffiliateWP;

use SureCart\Models\Checkout;
use SureCart\Models\Purchase;
use SureCart\Support\Currency;

/**
 * Custom Integration Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Custom_Integration
 * Use this class to ext
 */
class AffiliateWPIntegration extends \Affiliate_WP_Base {
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
		// add pending referral when the purchase is created.
		add_action( 'surecart/purchase_created', [ $this, 'addPendingReferral' ], 99 );
		// revoke referral when the purchase is revoked.
		add_action( 'surecart/purchase_revoked', [ $this, 'revokeReferral' ], 10, 3 );
		// re-complete referral when the purchase is completed.
		add_action( 'surecart/purchase_invoked', [ $this, 'invokeReferral' ], 10, 3 );
		// add a reference link to the referral table.
		add_filter( 'affwp_referral_reference_column', [ $this, 'referenceLink' ], 10, 2 );
	}

	/**
	 * The reference link for the referral.
	 *
	 * @param string $reference The reference id.
	 * @param object $referral The referral object.
	 *
	 * @return string
	 */
	public function referenceLink( $reference, $referral ) {
		if ( empty( $referral->context ) || 'surecart' !== $referral->context ) {
			return $reference;
		}

		$url         = '';
		$object_name = $referral->custom['object'] ?? 'order';

		$object = Checkout::find( $reference );

		if ( $object->id ) {
			$url = esc_url( \SureCart::getUrl()->edit( $object_name, $object->id ) );
		}

		if ( ! $url ) {
			return $reference;
		}

		return '<a href="' . esc_url( $url ) . '">#' . $object->number . '</a>';
	}

	/**
	 * Reject referral when purchase is revoked.
	 *
	 * @param \SureCart\Models\Purchase $purchase Purchase model.
	 *
	 * @return void
	 */
	public function revokeReferral( $purchase ) {
		if ( ! affiliate_wp()->settings->get( 'revoke_on_refund' ) ) {
			return;
		}

		$this->reject_referral( $purchase->invoice ?? $purchase->order );
	}

	/**
	 * Complete referral when purchase is invoked.
	 *
	 * @param \SureCart\Models\Purchase $purchase Purchase model.
	 *
	 * @return void
	 */
	public function invokeReferral( $purchase ) {
		$this->complete_referral( $purchase->invoice ?? $purchase->order );
	}

	/**
	 * Records a pending referral when a pending payment is created
	 *
	 * @param \SureCart\Models\Purchase $purchase Purchase model.
	 */
	public function addPendingReferral( $purchase ) {
		// the integration is not active.
		if ( ! $this->is_active() ) {
			return;
		}

		// Check if it was referred.
		if ( ! $this->was_referred() ) {
			return false; // Referral not created because affiliate was not referred.
		}

		$hydrated_purchase = Purchase::with( [ 'initial_order', 'order.checkout', 'product', 'customer' ] )->find( $purchase->id );

		// get the order reference.
		$reference = $hydrated_purchase->initial_order ?? null;

		// we must have an order id.
		if ( ! $reference->id ) {
			$this->log( 'Draft referral creation failed. No order attached.' );
			return;
		}

		// Create draft referral.
		$referral_id = $this->insert_draft_referral(
			$this->affiliate_id,
			[
				'reference' => $reference->id ?? null,
			]
		);

		if ( ! $referral_id ) {
			$this->log( 'Draft referral creation failed.' );
			return;
		}

		$stripe_amount = $reference->checkout->amount_due;
		$currency      = $reference->currency;
		$description   = $hydrated_purchase->product->name;
		$mode          = $reference->live_mode;

		if ( Currency::isZeroDecimal( $currency ) ) {
			$amount = $stripe_amount;
		} else {
			$amount = round( $stripe_amount / 100, 2 );
		}

		if ( $this->is_affiliate_email( $hydrated_purchase->customer->email, $this->affiliate_id ) ) {
			$this->log( 'Referral not created because affiliate\'s own account was used.' );
			$this->mark_referral_failed( $referral_id );
			return;
		}

		$referral_total = $this->calculate_referral_amount( $amount, $reference->id );

		// Hydrates the previously created referral.
		$this->hydrate_referral(
			$referral_id,
			array(
				'status'      => 'pending',
				'amount'      => $referral_total,
				'description' => $description,
				'custom'      => array(
					'livemode' => $mode,
					'object'   => $reference->object,
				),
			)
		);

		$this->log( 'Pending referral created successfully during insert_referral()' );

		if ( $this->complete_referral( $reference->id ) ) {
			$this->log( 'Referral completed successfully during insert_referral()' );
			return;
		}

		$this->log( 'Referral failed to be set to completed with complete_referral()' );
	}

}
