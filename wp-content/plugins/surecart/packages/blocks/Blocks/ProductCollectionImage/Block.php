<?php

namespace SureCartBlocks\Blocks\ProductCollectionImage;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Product Collection Image Block
 */
class Block extends BaseBlock {

	/**
	 * Get image styles.
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	private function getImageStyle( $attributes ): string {
		$style = '';

		// Aspect ratio with a height set needs to override the default width/height.
		if ( ! empty( $attributes['aspectRatio'] ) ) {
			$style .= 'width:100%;height:100%;';
		} elseif ( ! empty( $attributes['height'] ) ) {
			$style .= "height:{$attributes['height']};";
		}

		if ( ! empty( $attributes['scale'] ) ) {
			$style .= "object-fit:{$attributes['scale']};";
		}

		return $style;
	}

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
		if ( empty( $collection ) || empty( $collection->image ) ) {
			return '';
		}

		// Wrapper attributes.
		$aspect_ratio = ! empty( $attributes['aspectRatio'] ) ? esc_attr( safecss_filter_attr( 'aspect-ratio:' . $attributes['aspectRatio'] ) ) . ';' : '';
		$width        = ! empty( $attributes['width'] ) ? esc_attr( safecss_filter_attr( 'width:' . $attributes['width'] ) ) . ';' : '';
		$height       = ! empty( $attributes['height'] ) ? esc_attr( safecss_filter_attr( 'height:' . $attributes['height'] ) ) . ';' : '';

		if ( ! $height && ! $width && ! $aspect_ratio ) {
			$wrapper_attributes = get_block_wrapper_attributes();
		} else {
			$wrapper_attributes = get_block_wrapper_attributes( [ 'style' => $aspect_ratio . $width . $height ] );
		}

		// if % is used, we need to set the cdn_image_size = 0, so that it will use the full size image.
		if ( ! empty( $attributes['width'] ) ) {
			$cdn_image_size = strpos( $attributes['width'], '%' ) !== false ? 0 : $attributes['width'] ?? 0;
		} else {
			$cdn_image_size = 0;
		}

		$collection_image = sprintf(
			'<img src="%1$s" alt="%2$s" style="%3$s" srcset="%4$s" width="%5$s" height="%6$s" />',
			esc_url( $collection->getImageUrl( $cdn_image_size ) ),
			esc_attr( $collection->name ?? '' ),
			$this->getImageStyle( $attributes ),
			$collection->getImageUrl( $cdn_image_size, 'dpr=2' ) . ' 2x',
			! empty( $attributes['width'] ) ? (int) $attributes['width'] : null,
			! empty( $attributes['height'] ) ? (int) $attributes['height'] : null
		);

		return "<figure {$wrapper_attributes}>{$collection_image}</figure>";
	}
}
