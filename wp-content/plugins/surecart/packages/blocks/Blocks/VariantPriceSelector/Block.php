<?php

namespace SureCartBlocks\Blocks\VariantPriceSelector;

use SureCart\Models\Component;
use SureCart\Models\Product;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Product Variant Selector Block.
 */
class Block extends BaseBlock {
	/**
	 * Keep track of number of instances.
	 *
	 * @var integer
	 */
	public static $instance = 0;

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content = '' ) {
		$product = Product::with(
			[
				'prices',
				'variants',
				'variant_options',
			]
		)->find( $attributes['product_id'] );

		if ( empty( $product ) || is_wp_error( $product ) ) {
			return '';
		}

		// only active prices.
		$product = $product->withActivePrices()->withSortedPrices();

		// active prices.
		$first_variant_with_stock = $product->first_variant_with_stock;

		// must have at least one active price.
		if ( empty( $product->prices->data[0] ) ) {
			return '';
		}

		if ( ! empty( $product->prices->data[0]->id ) ) {
			$line_item = array_merge(
				[
					'price_id' => $product->prices->data[0]->id,
					'quantity' => 1,
				],
				! empty( $first_variant_with_stock->id ) ? [ 'variant_id' => $first_variant_with_stock->id ] : []
			);

			sc_initial_state(
				[
					'checkout' => [
						'initialLineItems' => sc_initial_line_items( [ $line_item ] ),
					],
				]
			);
		}

		self::$instance++;

		return wp_kses_post(
			Component::tag( 'sc-checkout-product-price-variant-selector' )
			->id( 'sc-checkout-product-price-variant-selector-' . (int) self::$instance )
			->with(
				[
					'product'       => $product,
					'label'         => ! empty( $attributes['label'] ) ? $attributes['label'] : '',
					'selectorTitle' => ! empty( $attributes['selectorTitle'] ) ? $attributes['selectorTitle'] : '',
				]
			)->render( '' )
		);
	}
}
