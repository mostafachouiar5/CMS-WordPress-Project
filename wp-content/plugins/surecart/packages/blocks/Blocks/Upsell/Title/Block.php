<?php

namespace SureCartBlocks\Blocks\Upsell\Title;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Upsell CTA Block.
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
		$upsell = get_query_var( 'surecart_current_upsell' );

		return wp_sprintf(
			'<%1$s class="%2$s" style="%3$s">
				%4$s
			</%1$s>',
			'h' . (int) ( $attributes['level'] ?? 1 ),
			esc_attr( $this->getClasses( $attributes ) . ' surecart-block upsell-title' ),
			esc_attr( $this->getStyles( $attributes ) ),
			wp_kses_post( $upsell->metadata->title ?? __( "Wait! Here's an exclusive offer for you.", 'surecart' ) )
		);
	}
}
