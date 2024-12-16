<?php
namespace SureCart\Permissions;

/**
 * Adds roles and capabilities.
 */
class RolesService {
	/**
	 * Create roles and caps.
	 *
	 * @return void
	 */
	public function create() {
		$this->addRoles();
		$this->addCaps();
	}

	/**
	 * Create roles and caps.
	 *
	 * @return void
	 */
	public function delete() {
		$this->removeRoles();
		// $this->removeCaps();
	}

	/**
	 * Add Roles.
	 *
	 * @return void
	 */
	public function addRoles() {
		add_role(
			'sc_shop_manager',
			__( 'SureCart Shop Manager', 'surecart' ),
			[
				'read'                   => true,
				'edit_posts'             => true,
				'delete_posts'           => true,
				'unfiltered_html'        => true,
				'upload_files'           => true,
				'export'                 => true,
				'import'                 => true,
				'delete_others_pages'    => true,
				'delete_others_posts'    => true,
				'delete_pages'           => true,
				'delete_private_pages'   => true,
				'delete_private_posts'   => true,
				'delete_published_pages' => true,
				'delete_published_posts' => true,
				'edit_others_pages'      => true,
				'edit_others_posts'      => true,
				'edit_pages'             => true,
				'edit_private_pages'     => true,
				'edit_private_posts'     => true,
				'edit_published_pages'   => true,
				'edit_published_posts'   => true,
				'manage_categories'      => true,
				'manage_links'           => true,
				'moderate_comments'      => true,
				'publish_pages'          => true,
				'publish_posts'          => true,
				'read_private_pages'     => true,
				'read_private_posts'     => true,
			]
		);

		add_role(
			'sc_shop_accountant',
			__( 'SureCart Accountant', 'surecart' ),
			[
				'read'         => true,
				'edit_posts'   => false,
				'delete_posts' => false,
			]
		);

		add_role(
			'sc_shop_worker',
			__( 'SureCart Shop Worker', 'surecart' ),
			[
				'read'         => true,
				'edit_posts'   => false,
				'upload_files' => true,
				'delete_posts' => false,
			]
		);

		add_role(
			'sc_customer',
			__( 'SureCart Customer', 'surecart' ),
			[
				'read' => true,
			]
		);
	}

	/**
	 * Add new shop-specific capabilities
	 *
	 * @since  1.4.4
	 * @global WP_Roles $wp_roles
	 * @return void
	 */
	public function addCaps() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				// phpcs:ignore
				$wp_roles = new \WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'sc_shop_manager', 'view_sc_shop_reports' );
			$wp_roles->add_cap( 'sc_shop_manager', 'view_sc_shop_sensitive_data' );
			$wp_roles->add_cap( 'sc_shop_manager', 'export_sc_shop_reports' );
			$wp_roles->add_cap( 'sc_shop_manager', 'manage_sc_shop_settings' );
			$wp_roles->add_cap( 'sc_shop_manager', 'list_users' );
			$wp_roles->add_cap( 'sc_shop_manager', 'edit_user' );

			$wp_roles->add_cap( 'administrator', 'view_sc_shop_reports' );
			$wp_roles->add_cap( 'administrator', 'view_sc_shop_sensitive_data' );
			$wp_roles->add_cap( 'administrator', 'export_sc_shop_reports' );
			$wp_roles->add_cap( 'administrator', 'manage_sc_shop_settings' );
			$wp_roles->add_cap( 'administrator', 'manage_sc_account_settings' );

			// Add the main model capabilities.
			$capabilities = $this->getModelCaps();
			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'administrator', $cap );
					$wp_roles->add_cap( 'sc_shop_manager', $cap );
					$wp_roles->add_cap( 'sc_shop_worker', $cap );
				}
			}

			$wp_roles->add_cap( 'sc_shop_accountant', 'edit_sc_products' );
			$wp_roles->add_cap( 'sc_shop_accountant', 'view_sc_shop_reports' );
			$wp_roles->add_cap( 'sc_shop_accountant', 'export_sc_shop_reports' );
			$wp_roles->add_cap( 'sc_shop_accountant', 'edit_sc_shop_charges' );
		}
	}

	/**
	 * Gets the core post type capabilities
	 *
	 * @since  1.4.4
	 * @return array $capabilities Core post type capabilities
	 */
	public function getModelCaps() {
		$capabilities = [];

		$capability_types = [
			'sc_coupon',
			'sc_promotion',
			'sc_balance_transaction',
			'sc_checkout',
			'sc_purchase',
			'sc_webhook',
			'sc_product',
			'sc_license',
			'sc_customer',
			'sc_order',
			'sc_invoice',
			'sc_price',
			'sc_refund',
			'sc_charge',
			'sc_media',
			'sc_payment_method',
			'sc_subscription',
			'sc_affiliate',
		];

		foreach ( $capability_types as $capability_type ) {
			$capabilities[ $capability_type ] = array(
				// Models.
				"read_{$capability_type}", // read.
				"read_{$capability_type}s", // read.
				"delete_{$capability_type}", // delete.
				"edit_{$capability_type}", // edit.
				"edit_{$capability_type}s", // edit all.
				"edit_others_{$capability_type}s", // edit others.
				"publish_{$capability_type}s", // publish.
				"delete_{$capability_type}s", // delete.
				"delete_others_{$capability_type}s", // delete others.

				// Stats.
				"view_{$capability_type}_stats",
			);
		}

		return $capabilities;
	}

	/**
	 * Remove Roles.
	 *
	 * @return void
	 */
	public function removeRoles() {
		remove_role( 'sc_shop_manager' );
		remove_role( 'sc_shop_accountant' );
		remove_role( 'sc_shop_worker' );
	}

	/**
	 * Remove Caps.
	 *
	 * @return void
	 */
	public function removeCaps() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				// phpcs:ignore
				$wp_roles = new \WP_Roles();
			}
		}

		$delete_caps = array_merge(
			[
				'view_sc_shop_reports',
				'view_sc_shop_sensitive_data',
				'export_sc_shop_reports',
				'manage_sc_shop_settings',
				'manage_sc_account_settings',
			],
			$this->getModelCaps()
		);

		foreach ( $delete_caps as $cap ) {
			foreach ( array_keys( $wp_roles->roles ) as $role ) {
				$wp_roles->remove_cap( $role, $cap );
			}
		}
	}
}
