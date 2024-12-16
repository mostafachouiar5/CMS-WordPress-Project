<?php

namespace SureCartBlocks\Blocks\Product;

use SureCart\Models\Product;
use SureCartBlocks\Blocks\BaseBlock;
use SureCart\Models\Form;

/**
 * Product Block
 */
abstract class ProductBlock extends BaseBlock {
	/**
	 * Set initial product state
	 *
	 * @param Product $product The current product.
	 *
	 * @return void
	 */
	public function setInitialState( $product ) {
		if ( empty( $product->id ) ) {
			return;
		}

		$state = sc_initial_state();

		// we already have state for this product.
		if ( ! empty( $state['product'][ $product->id ] ) ) {
			return;
		}

		$product_state[ $product->id ] = $product->getInitialPageState();
		$form = \SureCart::forms()->getDefault();

		sc_initial_state(
			[
				'product' => $product_state,
				'checkout' => [
					'formId'  => $form ? $form->ID : '',
					'mode'    => Form::getMode( $form->ID ),
					'persist' => 'browser',
				],
			]
		);
	}

	/**
	 * Get the product
	 *
	 * @param string $id The product id.
	 *
	 * @return Product|null
	 */
	public function getProduct( string $id ) {
		if ( empty( $id ) ) {
			return get_query_var( 'surecart_current_product' );
		}

		$product = Product::with( [ 'image', 'prices', 'product_medias', 'variant_options', 'variants', 'product_media.media', 'product_collections' ] )->find( $id );

		return ! empty( $product->id ) ? $product : null;
	}

	/**
	 * Get product and call set state.
	 *
	 * @param string $id The product id.
	 *
	 * @return \SureCart\Models\Product|null
	 */
	public function getProductAndSetInitialState( $id ) {
		$product = $this->getProduct( $id );

		if ( empty( $product ) ) {
			return;
		}

		$this->setInitialState( $product );

		return $product;
	}
}
