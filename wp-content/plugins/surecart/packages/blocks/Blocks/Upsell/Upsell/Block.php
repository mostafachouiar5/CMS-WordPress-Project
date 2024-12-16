<?php

namespace SureCartBlocks\Blocks\Upsell\Upsell;

use SureCart\Models\Blocks\ProductPageBlock;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Upsell Description Block
 */
class Block extends BaseBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		$controller = new ProductPageBlock();
		$state      = $controller->state();
		$context    = $controller->context();
		wp_interactivity_state( 'surecart/product-page', $state );

		return wp_sprintf(
			'<div %s> <sc-upsell %s>%s</sc-upsell>',
			wp_kses_data( wp_interactivity_data_wp_context( $context ) ),
			get_block_wrapper_attributes(),
			filter_block_content( $content, 'post' )
		);
	}
}
