<?php

namespace SureCartBlocks\Blocks\Dashboard;

use SureCartBlocks\Blocks\BaseBlock;
use SureCart\Models\User;

/**
 * Checkout block
 */
abstract class DashboardPage extends BaseBlock {
	/**
	 * Holds the customer object.
	 *
	 * @var \SureCart\Models\Customer|null|\WP_Error;
	 */
	protected $customer = null;

	/**
	 * Holds the customer id.
	 *
	 * @var string
	 */
	protected $customer_id = null;

	/**
	 * Get the current tab.
	 */
	protected function getTab() {
		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : false;
		if ( $tab ) {
			return $tab;
		}

		global $post;
		$postcontent = $post->post_content;
		$blocks      = parse_blocks( $postcontent );
		$named       = \SureCart::block()->filterBy( 'blockName', 'surecart/dashboard-tab', $blocks );
		return ! empty( $named[0]['attrs']['panel'] ) ? $named[0]['attrs']['panel'] : $tab;
	}

	/**
	 * Run middleware before rendering the block.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content   Post content.
	 * @return boolean|\WP_Error;
	 */
	protected function middleware( $attributes, $content ) {
		// user must be logged in.
		if ( ! is_user_logged_in() ) {
			return \SureCart::block()->render( 'web/login' );
		}

		// cannot get user.
		$user = User::current();
		if ( ! $user ) {
			return false;
		}

		return true;
	}


	protected function isLiveMode() {
		if ( 'false' === sanitize_text_field( wp_unslash( $_GET['live_mode'] ?? '' ) ) ) {
			return false;
		}
		return true;
	}
}
