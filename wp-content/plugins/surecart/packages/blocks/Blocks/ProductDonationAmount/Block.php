<?php

namespace SureCartBlocks\Blocks\ProductDonationAmount;

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
				'value'      => esc_attr( $attributes['amount'] ?? '' ),
				'product-id' => esc_attr( $this->block->context['surecart/product-donation/product_id'] ?? '' ),
				'label'      => esc_attr( $attributes['label'] ?? '' ),
				'recurring'  => ! empty( $attributes['recurring'] ) ? 'true' : 'false',
				'product-id' => esc_attr( $this->block->context['surecart/product-donation/product_id'] ?? '' ),
			]
		);

		return wp_sprintf(
			'<sc-product-donation-amount-choice %s></sc-product-donation-amount-choice>',
			$wrapper_attributes,
		);
	}
}
