<?php

namespace SureCart\Integrations\LearnDashGroup;

use SureCart\Integrations\Contracts\IntegrationInterface;
use SureCart\Integrations\Contracts\PurchaseSyncInterface;
use SureCart\Integrations\IntegrationService;

/**
 * Controls the LearnDash Group integration.
 */
class LearnDashGroupService extends IntegrationService implements IntegrationInterface, PurchaseSyncInterface {
	/**
	 * Get the slug for the integration.
	 *
	 * @return string
	 */
	public function getName() {
		return 'surecart/learndash-groups';
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
	 * Get the logo for the integration.
	 *
	 * @return string
	 */
	public function getLogo() {
		return esc_url_raw( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'images/integrations/learndash.svg' );
	}

	/**
	 * Get the label for the integration.
	 *
	 * @return string
	 */
	public function getLabel() {
		return __( 'LearnDash Groups', 'surecart' );
	}

	/**
	 * Get the item label for the integration.
	 *
	 * @return string
	 */
	public function getItemLabel() {
		return __( 'Group Access', 'surecart' );
	}

	/**
	 * Get the item help for the integration.
	 *
	 * @return string
	 */
	public function getItemHelp() {
		return __( 'Enable access to a LearnDash group.', 'surecart' );
	}

	/**
	 * Is this enabled?
	 *
	 * @return boolean
	 */
	public function enabled() {
		return defined( 'LEARNDASH_VERSION' );
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
		$course_query = new \WP_Query(
			[
				'post_type' => 'groups',
				's'         => $search,
				'per_page'  => 10,
			]
		);

		if ( ( isset( $course_query->posts ) ) && ( ! empty( $course_query->posts ) ) ) {
			$items = array_map(
				function( $post ) {
					return (object) [
						'id'    => $post->ID,
						'label' => $post->post_title,
					];
				},
				$course_query->posts
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
			'provider_label' => __( 'LearnDash Group', 'surecart' ),
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
	 * Update access to a group.
	 *
	 * @param integer  $group_id The group id.
	 * @param \WP_User $wp_user The user.
	 * @param boolean  $add True to add the user to the group, false to remove.
	 *
	 * @return boolean|void Returns true if the user group access updation was successful otherwise false.
	 */
	public function updateAccess( $group_id, $wp_user, $add = true ) {
		// we don't have learndash installed.
		if ( ! function_exists( 'ld_update_group_access' ) ) {
			return;
		}
		// update group access.
		return \ld_update_group_access( $wp_user->ID, $group_id, ! $add );
	}
}
