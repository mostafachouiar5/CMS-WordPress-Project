<?php

namespace SureCartBlocks\Blocks\ProductCollectionTitle;

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
		$collection = get_query_var( 'surecart_current_collection' );

		if ( empty( $collection ) ) {
			$term = get_queried_object();
			if ( empty( $term ) || empty( $term->term_id ) ) {
				return '';
			}

			$collection = sc_get_collection( $term->term_id );

			if ( empty( $collection ) ) {
				return '';
			}
		}

		return sprintf(
			'<%1$s class="%2$s" style="%3$s">
				%4$s
			</%1$s>',
			'h' . (int) ( $attributes['level'] ?? 1 ),
			esc_attr( $this->getClasses( $attributes ) . ' surecart-block collection-title' ),
			esc_attr( $this->getStyles( $attributes ) ),
			$collection->name
		);
	}
}
