<?php

namespace SureCart\Integrations\BuddyBoss;

use SureCart\Integrations\Contracts\IntegrationInterface;
use SureCart\Integrations\Contracts\PurchaseSyncInterface;
use SureCart\Integrations\IntegrationService;

/**
 * Controls the LearnDash integration.
 */
class BuddyBossService extends IntegrationService implements IntegrationInterface, PurchaseSyncInterface {
	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getName() {
		return 'surecart/buddyboss-platform';
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
		return esc_url_raw( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/integrations/buddyboss.svg' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getLabel() {
		return __( 'BuddyBoss Group', 'surecart' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getItemLabel() {
		return __( 'Group Access', 'surecart' );
	}

	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getItemHelp() {
		return __( 'Enable access to a BuddyBoss Group.', 'surecart' );
	}

	/**
	 * Is this enabled?
	 *
	 * @return boolean
	 */
	public function enabled() {
		return defined( 'BP_PLATFORM_VERSION' );
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
		$groups = \groups_get_groups(
			[
				'search_terms' => $search,
				'show_hidden'  => true,
			]
		);

		if ( ( isset( $groups ) ) && ( ! empty( $groups ) ) ) {
			$items = array_map(
				function( $group ) {
					return (object) [
						'id'    => $group->id,
						'label' => $group->name,
					];
				},
				$groups['groups']
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
		$group = \groups_get_group( $id );
		if ( ! $group ) {
			return (object) [];
		}

		return (object) [
			'id'             => $id,
			'provider_label' => __( 'BuddyBoss Group', 'surecart' ),
			'label'          => $group->name,
		];
	}

	/**
	 * Enable Access to the group.
	 *
	 * @param \SureCart\Models\Integration $integration The integrations.
	 * @param \WP_User                     $wp_user The user.
	 *
	 * @return boolean|void Returns true if the user group access updation was successful otherwise false.
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
	 * @return boolean|void Returns true if the user group access updation was successful otherwise false.
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
	 * @return boolean|void Returns true if the user group access updation was successful otherwise false.
	 */
	public function onPurchaseRevoked( $integration, $wp_user ) {
		$this->updateAccess( $integration->integration_id, $wp_user, false );
	}

	/**
	 * Update access to a group.
	 *
	 * @param integer  $group_id The group id.
	 * @param \WP_User $wp_user The user.
	 * @param boolean  $add True to add the user to the group, false to remove.
	 *
	 * @return boolean|void Returns true if the user group access updation was successful otherwise false.
	 */
	public function updateAccess( $group_id, $wp_user, $add = true ) {
		// we don't have BuddyBoss installed.
		if ( ! defined( 'BP_PLATFORM_VERSION' ) ) {
			return;
		}
		// update group access.
		if ( $add ) {
			return \groups_join_group( $group_id, $wp_user->ID, 'SureCart' );
		} else {
			return \groups_leave_group( $group_id, $wp_user->ID, 'SureCart' );
		}
	}
}
