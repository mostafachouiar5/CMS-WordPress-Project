<?php

namespace SureCart\Integrations;

/**
 * Abstract integrations class.
 */
abstract class AbstractIntegration {
	/**
	 * Run an action when a purchase is created
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseCreated( $integration, $wp_user ) {
		return new \WP_Error(
			'invalid-method',
			/* translators: %s: Method name. */
			sprintf( __( "Method '%s' not implemented. Must be overridden in subclass.", 'surecart' ), __METHOD__ ),
			array( 'status' => 405 )
		);
	}

	/**
	 * Run an action when a purchase is revoked.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseRevoked( $integration, $wp_user ) {
		return new \WP_Error(
			'invalid-method',
			/* translators: %s: Method name. */
			sprintf( __( "Method '%s' not implemented. Must be overridden in subclass.", 'surecart' ), __METHOD__ ),
			array( 'status' => 405 )
		);
	}

	/**
	 * Run an action when a purchase is invoked.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseInvoked( $integration, $wp_user ) {
		return new \WP_Error(
			'invalid-method',
			/* translators: %s: Method name. */
			sprintf( __( "Method '%s' not implemented. Must be overridden in subclass.", 'surecart' ), __METHOD__ ),
			array( 'status' => 405 )
		);
	}

	/**
	 * Method to run when the quantity updates.
	 *
	 * @param integer  $quantity The new quantity.
	 * @param integer  $previous The previous quantity.
	 * @param Purchase $purchase The purchase.
	 * @param array    $request The request.
	 *
	 * @return void
	 */
	public function onPurchaseQuantityUpdated( $quantity, $previous, $purchase, $request ) {
		// do nothing as this is not required.
	}

	/**
	 * Method to run when the purchase product is updated.
	 *
	 * @param Purchase $quantity The current purchase.
	 * @param Purchase $previous_purchase The previous purchase.
	 * @param array    $request The request.
	 *
	 * @return void|\WP_Error
	 */
	public function onPurchaseProductUpdated( \SureCart\Models\Purchase $purchase, \SureCart\Models\Purchase $previous_purchase, $request ) {
		return new \WP_Error(
			'invalid-method',
			/* translators: %s: Method name. */
			sprintf( __( "Method '%s' not implemented. Must be overridden in subclass.", 'surecart' ), __METHOD__ ),
			array( 'status' => 405 )
		);
	}

	/**
	 * The product was added.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return void
	 */
	public function onPurchaseProductAdded( $integration, $wp_user ) {
		$this->onPurchaseCreated( $integration, $wp_user );
	}

	/**
	 * Removed
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return void
	 */
	public function onPurchaseProductRemoved( $integration, $wp_user ) {
		$this->onPurchaseRevoked( $integration, $wp_user );
	}

	/**
	 * Method to run when a purchase is updated.
	 * This can occur if the product or quantity changes.
	 *
	 * @param Purchase $purchase The purchase.
	 * @param array    $request The request.
	 *
	 * @return void
	 */
	public function onPurchaseUpdated( \SureCart\Models\Purchase $purchase, $request ) {
		// do nothing as this is not required.
	}
}
