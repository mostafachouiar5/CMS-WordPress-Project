<?php

namespace SureCartBlocks\Blocks\Product\Description;

use SureCartBlocks\Blocks\Product\ProductBlock;

/**
 * Product Title Block
 */
class Block extends ProductBlock {
	/**
	 * Keep track of the instance number of this block.
	 *
	 * @var integer
	 */
	public static $instance;

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
		if ( empty( $product->description ) ) {
			return '';
		}

		$attributes = get_block_wrapper_attributes(
			[
				'class' => esc_attr( $this->getClasses( $attributes ) ),
				'style' => esc_attr( $this->getStyles( $attributes ) ),
			]
		);

		return wp_sprintf(
			'<div %1$s>%2$s</div>',
			$attributes,
			wp_kses_post( $product->description ?? '' )
		);
	}
}
