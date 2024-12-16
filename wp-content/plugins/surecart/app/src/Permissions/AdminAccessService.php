<?php

namespace SureCart\Permissions;

/**
 * Admin Access Service
 */
class AdminAccessService {

	/**
	 * Admin access service construct
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'admin_init', [ $this, 'handleAdminAccess' ] );
	}

	/**
	 * Prevent admin access
	 *
	 * @return method
	 */
	public function handleAdminAccess() {
		if ( ! $this->canAccessAdmin() ) {
			return $this->redirectToAdmin();
		}
	}

	/**
	 * Prevent admin access
	 *
	 * @return boolean
	 */
	public function canAccessAdmin() {
		if (
			wp_doing_ajax() ||
			! isset( $_SERVER['SCRIPT_FILENAME'] ) ||
			basename( sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_FILENAME'] ) ) ) === 'admin-post.php' ||
			current_user_can( 'edit_posts' )
		) {
			return true;
		}

		return ! current_user_can( 'sc_customer' );
	}

	/**
	 * Redirect to the admin.
	 *
	 * @return void
	 */
	public function redirectToAdmin() {
		wp_safe_redirect( \SureCart::pages()->url( 'dashboard' ) );
		exit;
	}
}
