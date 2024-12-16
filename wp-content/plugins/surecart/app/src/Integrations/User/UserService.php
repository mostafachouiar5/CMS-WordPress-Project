<?php

namespace SureCart\Integrations\User;

use SureCart\Integrations\Contracts\IntegrationInterface;
use SureCart\Integrations\Contracts\PurchaseSyncInterface;
use SureCart\Integrations\IntegrationService;

/**
 * Controls the LearnDash integration.
 */
class UserService extends IntegrationService implements IntegrationInterface, PurchaseSyncInterface {
	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getName() {
		return 'surecart/user-role';
	}

	/**
	 * Get the SureCart model used for the integration.
	 * Only 'product' is supported at this time.
	 *
	 * @return string
	 */
	public function getModel() {
		return 'product';
	}

	/**
	 * Get the integration logo url.
	 * This can be to a png, jpg, or svg for example.
	 *
	 * @return string
	 */
	public function getLogo() {
		return esc_url_raw( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/integrations/wordpress.svg' );
	}

	/**
	 * The display name for the integration in the dropdown.
	 *
	 * @return string
	 */
	public function getLabel() {
		return __( 'Add WordPress User Role', 'surecart' );
	}

	/**
	 * The label for the integration item that will be chosen.
	 *
	 * @return string
	 */
	public function getItemLabel() {
		return __( 'Add User Role', 'surecart' );
	}

	/**
	 * Help text for the integration item chooser.
	 *
	 * @return string
	 */
	public function getItemHelp() {
		return __( 'Add the user role of the user who purchased the product.', 'surecart' );
	}

	/**
	 * Get item listing for the integration.
	 * These are a list of item the merchant can choose from when adding an integration.
	 *
	 * @param array  $items The integration items.
	 * @param string $search The search term.
	 *
	 * @return array The items for the integration.
	 */
	public function getItems( $items = [], $search = '' ) {
		$roles          = [];
		$editable_roles = \wp_roles()->roles;
		foreach ( $editable_roles as $role => $details ) {
			if ( 'administrator' === $role ) {
				continue; // don't allow admin role.
			}
			$sub['id']      = esc_attr( $role );
			$sub['label']   = translate_user_role( $details['name'] );
			$roles[ $role ] = $sub;
		}
		return $roles;
	}

	/**
	 * Get the individual item.
	 *
	 * @param string $role The item role.
	 *
	 * @return array The item for the integration.
	 */
	public function getItem( $role ) {
		return [
			'id'    => $role,
			'label' => wp_roles()->get_names()[ $role ],
		];
	}

	/**
	 * Add the role when the purchase is created.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseCreated( $integration, $wp_user ) {
		$this->toggleRole( $integration->integration_id, $wp_user, true );
	}

	/**
	 * Add the role when the purchase is invoked
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
	 * Remove a user role when the purchase is revoked.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user course access updation was successful otherwise false.
	 */
	public function onPurchaseRevoked( $integration, $wp_user ) {
		$this->toggleRole( $integration->integration_id, $wp_user, false );
	}

	/**
	 * Toggle the role
	 *
	 * @param string   $role The role.
	 * @param \WP_User $wp_user  The user object.
	 * @param boolean  $add  True to add the role, false to remove.
	 *
	 * @return \WP_Role|false
	 */
	public function toggleRole( $role, $wp_user, $add = true ) {
		// make sure the role exists.
		$role_object = get_role( $role );
		if ( ! $role_object ) {
			return;
		}
		// add or remove the role.
		return $add ? $wp_user->add_role( $role ) : $wp_user->remove_role( $role );
	}
}
