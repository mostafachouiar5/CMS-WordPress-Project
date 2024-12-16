<?php

namespace SureCart\Integrations\Contracts;

interface PurchaseSyncInterface {
	/**
	 * Method is run when the purchase is created.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the updation was successful otherwise false.
	 */
	public function onPurchaseCreated( $integration, $wp_user );

	/**
	 * Method is run when the purchase is invoked
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the updation was successful otherwise false.
	 */
	public function onPurchaseInvoked( $integration, $wp_user );

	/**
	 * Method is run when the purchase is revoked.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the updation was successful otherwise false.
	 */
	public function onPurchaseRevoked( $integration, $wp_user );
}
