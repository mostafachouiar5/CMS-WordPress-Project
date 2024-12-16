<?php

namespace SureCartBlocks\Blocks\Product\Quantity;

use SureCartBlocks\Blocks\Product\ProductBlock;

/**
 * Product Title Block
 */
class Block extends ProductBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		$product = $this->getProductAndSetInitialState( $attributes['id'] ?? '' );
		if ( empty( $product->id ) ) {
			return '';
		}

		$attributes = get_block_wrapper_attributes(
			[
				'label'      => esc_attr( $attributes['label'] ?? '' ),
				'product-id' => esc_attr( $product->id ),
				'class'      => esc_attr( $this->getClasses( $attributes ) ),
				'style'      => esc_attr( $this->getStyles( $attributes ) ),
			]
		);

		return wp_sprintf(
			'<sc-product-quantity %1$s></sc-product-quantity>',
			$attributes
		);
	}
}
