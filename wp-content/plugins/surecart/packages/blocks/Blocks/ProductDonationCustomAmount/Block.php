<?php

namespace SureCartBlocks\Blocks\ProductDonationCustomAmount;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Logout Button Block.
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
		$wrapper_attributes = get_block_wrapper_attributes(
			[
				'product-id' => esc_attr( $this->block->context['surecart/product-donation/product_id'] ?? '' ),
			]
		);

		return wp_sprintf(
			'<sc-product-donation-custom-amount %s></sc-product-donation-custom-amount>',
			$wrapper_attributes,
		);
	}
}
