<?php

namespace SureCartBlocks\Blocks\Dashboard\DashboardTab;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Checkout block
 */
class Block extends BaseBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return void
	 */
	public function render( $attributes, $content ) {
		// we need a panel name.
		if ( empty( $attributes['panel'] ) ) {
			return;
		}

		// get the current page tab and possible id.
		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';

		return \SureCart::block()->render(
			'blocks/dashboard-tab',
			[
				'active' => $tab === $attributes['panel'] ? 'true' : 'false',
				'title'  => $attributes['title'] ?? '',
				'icon'   => $attributes['icon'] ?? 'home',
				'href'   => esc_url( add_query_arg( [ 'tab' => sanitize_title( $attributes['panel'] ) ], remove_query_arg( array_keys( $_GET ) ) ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			]
		);
	}
}
