<?php

namespace SureCartBlocks\Blocks\Product\Title;

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
		if ( empty( $product ) ) {
			return '';
		}

		$attributes = get_block_wrapper_attributes(
			[
				'class' => esc_attr( $this->getClasses( $attributes ) . ' surecart-block product-title' ),
				'style' => esc_attr( $this->getStyles( $attributes ) ),
			]
		);

		return sprintf(
			'<%1$s %2$s>
				%3$s
			</%1$s>',
			'h' . (int) ( $attributes['level'] ?? 1 ),
			$attributes,
			wp_kses_post( $product->name ?? '' )
		);
	}
}
