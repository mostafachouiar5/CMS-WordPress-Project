<?php

namespace SureCartBlocks\Blocks\Dashboard\OrderDownloads;

use SureCart\Models\Component;
use SureCart\Models\User;
use SureCartBlocks\Blocks\Dashboard\DashboardPage;

/**
 * Checkout block
 */
class Block extends DashboardPage {
	/**
	 * Render the preview (overview)
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return function
	 */
	public function render( $attributes, $content ) {
		if ( ! User::current()->isCustomer() ) {
			return;
		}
		return wp_kses_post(
			Component::tag( 'sc-downloads-list' )
			->id( 'customer-downloads-preview' )
			->with(
				[
					'allLink' => add_query_arg(
						[
							'tab'    => $this->getTab(),
							'model'  => 'download',
							'action' => 'index',
						],
						\SureCart::pages()->url( 'dashboard' )
					),
					'nonce'   => wp_create_nonce( 'customer-download' ),
					'query'   => [
						'order_ids' => array_values( User::current()->customerIds() ),
						'page'      => 1,
						'per_page'  => 10,
					],
				]
			)->render( $attributes['title'] ? "<span slot='heading'>" . $attributes['title'] . '</span>' : '' ) );
	}
}
