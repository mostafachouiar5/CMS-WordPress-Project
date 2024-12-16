<?php

namespace SureCartBlocks\Blocks\ProductCollectionDescription;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Product Title Block
 */
class Block extends BaseBlock {
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

		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'entry-content' ) );

		return (
			'<div ' . $wrapper_attributes . '>' .
			wp_kses_post( $collection->description ) .
			'</div>'
		);
	}
}
