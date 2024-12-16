<?php

declare(strict_types=1);

namespace SureCart\BlockValidator;

use \SureCartBlocks\Blocks\Product\VariantChoices\Block as VariantChoicesBlock;

/**
 * VariantChoice Block validator.
 */
class VariantChoice extends BlockValidator {
	/**
	 * Has this run before?
	 *
	 * @var boolean
	 */
	protected static $has_run = false;

	/**
	 * The name of the block to validate.
	 *
	 * @var string
	 */
	protected $block_name = 'surecart/product-buy-button';

	/**
	 * Validate block.
	 *
	 * @param string $block_content The block content.
	 * @param array  $block The block.
	 *
	 * @return bool True if the block is valid, false otherwise.
	 */
	protected function isValid( string $block_content, array $block ): bool {
		$product = get_query_var( 'surecart_current_product' );

		// we have already run this.
		if ( self::$has_run ) {
			return true;
		}

		// If not in product page return.
		if ( empty( $product ) || ! $product instanceof \SureCart\Models\Product ) {
			return true;
		}

		// If no variant, return.
		if ( ! count( $product->variants->data ?? [] ) ) {
			return true;
		}

		// If has block already exist, return.
		if ( has_block( 'surecart/product-variant-choices' ) ) {
			return true;
		}

		// We only want to run once.
		self::$has_run = true;

		// We don't have a variant choice block.
		return false;
	}

	/**
	 * Render block.
	 *
	 * @param string $block_content The block content.
	 * @param array  $block The block.
	 *
	 * @return string
	 */
	protected function render( string $block_content, array $block ): string {
		$appended_block = render_block(
			[
				'blockName' => 'surecart/product-variant-choices',
				'attrs'     => [],
			]
		);
		return $appended_block . $block_content;
	}
}
