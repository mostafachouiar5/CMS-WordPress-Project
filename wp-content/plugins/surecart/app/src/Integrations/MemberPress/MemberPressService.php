<?php

namespace SureCart\Integrations\MemberPress;

use SureCart\Integrations\Contracts\IntegrationInterface;
use SureCart\Integrations\Contracts\PurchaseSyncInterface;
use SureCart\Integrations\IntegrationService;
use SureCart\Models\Purchase;
use SureCart\Support\Currency;

/**
 * Controls the MemberPress integration.
 */
class MemberPressService extends IntegrationService implements IntegrationInterface, PurchaseSyncInterface {
	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getName() {
		return 'surecart/memberpress';
	}

	/**
	 * Get the model for the integration.
	 *
	 * @return string
	 */
	public function getModel() {
		return 'product';
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getLogo() {
		return esc_url_raw( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/integrations/memberpress.svg' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getLabel() {
		return __( 'MemberPress Membership', 'surecart' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getItemLabel() {
		return __( 'Membership Access', 'surecart' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getItemHelp() {
		return __( 'Enable access to a MemberPress membership.', 'surecart' );
	}

	/**
	 * Is this enabled?
	 *
	 * @return boolean
	 */
	public function enabled() {
		return defined( 'MEPR_VERSION' );
	}

	/**
	 * Get item listing for the integration.
	 *
	 * @param array  $items The integration items.
	 * @param string $search The search term.
	 *
	 * @return array The items for the integration.
	 */
	public function getItems( $items = [], $search = '' ) {
		if ( ! class_exists( 'MeprProduct' ) ) {
			return [];
		}

		$membership_query = new \WP_Query(
			[
				'post_type' => \MeprProduct::$cpt,
				's'         => $search,
				'per_page'  => 10,
			]
		);

		if ( ( isset( $membership_query->posts ) ) && ( ! empty( $membership_query->posts ) ) ) {
			$items = array_map(
				function( $post ) {
					return (object) [
						'id'    => $post->ID,
						'label' => $post->post_title,
					];
				},
				$membership_query->posts
			);
		}

		return $items;
	}

	/**
	 * Get the individual item.
	 *
	 * @param string $id Id for the record.
	 *
	 * @return object The item for the integration.
	 */
	public function getItem( $id ) {
		$course = get_post( $id );
		if ( ! $course ) {
			return [];
		}
		return (object) [
			'id'             => $id,
			'provider_label' => __( 'MemberPress Membership', 'surecart' ),
			'label'          => $course->post_title,
		];
	}

	/**
	 * Enable Access to the course.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseCreated( $integration, $wp_user ) {
		$this->updateAccess( $integration->integration_id, $wp_user, true );
	}

	/**
	 * Enable access when purchase is invoked
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseInvoked( $integration, $wp_user ) {
		$this->onPurchaseCreated( $integration, $wp_user );
	}

	/**
	 * Remove a user role.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseRevoked( $integration, $wp_user ) {
		$this->updateAccess( $integration->integration_id, $wp_user, false );
	}

	/**
	 * Update access to a course.
	 *
	 * @param integer  $membership_id The membership product id.
	 * @param \WP_User $wp_user The user.
	 * @param boolean  $add True to add the user to the course, false to remove.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function updateAccess( $membership_id, $wp_user, $add = true ) {
		// we don't have Memberpress installed.
		if ( ! class_exists( 'MeprTransaction' ) ) {
			return;
		}

		// make sure we have a purchase id.
		if ( empty( $this->getPurchaseId() ) ) {
			return;
		}

		// get order, invoice needed to sync the purchase.
		$purchase             = Purchase::with( [ 'order', 'invoice' ] )->find( $this->getPurchaseId() );
		$status               = $add ? 'completed' : 'failed';
		$existing             = false;
		$transaction_num      = $purchase->id;
		$existing_transaction = \MeprTransaction::get_one_by_trans_num( $transaction_num );

		// get purchase order or invoice.
		if ( ! empty( $purchase->order->id ) ) {
			$object = $purchase->order;
		}
		if ( ! empty( $purchase->invoice->id ) ) {
			$object = $purchase->invoice;
		}

		// It doesn't exist.
		if ( ! isset( $existing_transaction->id ) || empty( $existing_transaction->id ) ) {
			$transaction             = new \MeprTransaction();
			$transaction->amount     = $this->convertAmount( $object->amount_due, $object->currency );
			$transaction->total      = $this->convertAmount( $object->total_amount, $object->currency );
			$transaction->tax_amount = $this->convertAmount( $object->tax_amount, $object->currency );
			$transaction->user_id    = $wp_user->ID;
			$transaction->product_id = $membership_id;
			$transaction->trans_num  = $transaction_num;
			$transaction->txn_type   = \MeprTransaction::$payment_str;
			$transaction->gateway    = 'manual';
			$transaction->created_at = gmdate( 'c' );
			$transaction->expires_at = \MeprUtils::mysql_lifetime();
		} else {
			// It does exist.
			$transaction = new \MeprTransaction( $existing_transaction->id );
			$existing    = true;
		}

		// Fire some hooks for Corporate Accounts.
		if ( ! $existing ) {
			$transaction->status = \MeprTransaction::$pending_str;
			$transaction->store();
			do_action( 'mepr-signup', $transaction );
		}

		// Set the txn's status.
		if ( 'failed' === $status ) {
			$transaction->status = \MeprTransaction::$failed_str;
		} else {
			$transaction->status = \MeprTransaction::$complete_str;
		}

		// Store the transaction.
		return $transaction->store();
	}

	/**
	 * Maybe convert to non-zero decimal.
	 *
	 * @param integer $amount The amount as an integer.
	 * @param string  $currency The currency.
	 *
	 * @return float|integer The new amount.
	 */
	public function convertAmount( $amount, $currency ) {
		return Currency::isZeroDecimal( $currency ) ? $amount : round( $amount / 100, 2 );
	}
}
