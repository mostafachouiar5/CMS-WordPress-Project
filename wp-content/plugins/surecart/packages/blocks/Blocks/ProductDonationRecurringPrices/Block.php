<?php

namespace SureCartBlocks\Blocks\ProductDonationRecurringPrices;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Product Title Block
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
				'recurring'  => ! empty( $attributes['recurring'] ) ? 'true' : 'false',
				'product-id' => esc_attr( $this->block->context['surecart/product-donation/product_id'] ?? '' ),
			]
		);

		return wp_sprintf(
			'<sc-product-donation-choices %s>%s</sc-product-donation-choices>',
			$wrapper_attributes,
			esc_attr( $attributes['label'] ?? '' )
		);
	}
}
