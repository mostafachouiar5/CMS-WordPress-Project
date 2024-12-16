<?php

namespace SureCartBlocks\Blocks\Product\PriceChoices;

use SureCartBlocks\Blocks\Product\ProductBlock;
use SureCartBlocks\Util\BlockStyleAttributes;

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
		if ( empty( $attributes['id'] ) ) {
			return \SureCart::block()
			->productPriceChoicesMigration( $attributes, $this->block )
			->render();
		}

		$product = $this->getProductAndSetInitialState( $attributes['id'] ?? '' );
		if ( empty( $product->id ) ) {
			return '';
		}
		['styles' => $styles] = BlockStyleAttributes::getClassesAndStylesFromAttributes( $attributes, [ 'margin' ] );

		$attributes = get_block_wrapper_attributes(
			[
				'label'      => esc_attr( $attributes['label'] ?? '' ),
				'class'      => 'surecart-block product-price-choices',
				'product-id' => esc_attr( $product->id ),
				'style'      => esc_attr( $this->getVars( $attributes, '--sc-choice' ) . ' --columns: ' . $attributes['columns'] ?? 2 . '; border: none; ' . $styles ),
				'show-price' => wp_validate_boolean( $attributes['show_price'] ) ? 'true' : 'false',
			]
		);

		return wp_sprintf(
			'<sc-product-price-choices %1$s></sc-product-price-choices>',
			$attributes
		);
	}
}
