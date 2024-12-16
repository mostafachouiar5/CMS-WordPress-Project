<?php

declare(strict_types=1);

namespace SureCart\Controllers\Web;

/**
 * Handles Checkout related routes.
 */
class CheckoutFormsController {

	/**
	 * Change the mode of the checkout form.
	 */
	public function changeMode() {
		$form_post_id       = get_query_var( 'sc_checkout_change_mode' );
		$checkout_post_id   = get_query_var( 'sc_checkout_post' );
		$form_post          = get_post( $form_post_id );
		$checkout_page_post = get_post( $checkout_post_id );

		if ( empty( $form_post ) || empty( $checkout_page_post ) ) {
			wp_die( esc_html__( 'Invalid request.', 'surecart' ) );
		}

		$form_block = \SureCart::post()->getFormBlock( $checkout_page_post );
		if ( ! $form_block ) {
			wp_die( esc_html__( 'There is no checkout form block on this page.', 'surecart' ) );
		}

		// Get the mode.
		$mode = $form_block['attrs']['mode'] ?? 'live';

		// Change the mode.
		$form_block['attrs']['mode'] = 'test' === $mode ? 'live' : 'test';

		// Update the post.
		wp_update_post(
			array(
				'ID'           => $form_post_id,
				'post_content' => serialize_blocks( [ $form_block ] ),
			)
		);

		// Redirect to the checkout page.
		return \SureCart::redirect()->to( get_permalink( $checkout_post_id ) );
	}
}
