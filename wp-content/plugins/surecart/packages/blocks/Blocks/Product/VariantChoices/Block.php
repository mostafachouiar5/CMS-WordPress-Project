<?php

namespace SureCartBlocks\Blocks\Product\VariantChoices;

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
		if ( empty( $attributes['id'] ) && empty( get_query_var( 'sc_upsell_id' ) ) ) {
			return \SureCart::block()
			->productVariantsMigration( $attributes, $this->block )
			->render();
		}

		// check for product.
		$product = $this->getProductAndSetInitialState( $attributes['id'] ?? '' );
		if ( empty( $product ) || empty( $product->variant_options->data ) ) {
			return '';
		}

		[ 'styles' => $styles] = BlockStyleAttributes::getClassesAndStylesFromAttributes( $attributes, [ 'margin' ] );

		$attributes = get_block_wrapper_attributes(
			[
				'style' => 'border: none; display: block; margin-bottom: var(--sc-form-row-spacing, 0.75em);' . esc_attr( $this->getVars( $attributes, '--sc-pill-option' ) ),
			]
		);

		ob_start(); ?>

		<div style="<?php echo esc_attr( $styles ); ?>">
			<?php foreach ( $product->variant_options->data as $key => $option ) : ?>
				<sc-product-pills-variant-option product-id="<?php echo esc_attr( $product->id ); ?>" label="<?php echo esc_attr( $option->name ); ?>" option-number="<?php echo (int) $key + 1; ?>" <?php echo $attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></sc-product-pills-variant-option>
			<?php endforeach; ?>
		</div>

		<?php
		return ob_get_clean();
	}
}
