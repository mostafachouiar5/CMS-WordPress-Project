<?php

namespace SureCartBlocks\Blocks\Product\Media;

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
		global $content_width;
		$product = $this->getProductAndSetInitialState( $attributes['id'] ?? '' );
		if ( empty( $product ) ) {
			return '';
		}

		// no product media, show placeholder.
		if ( empty( $product->product_medias->data ) ) {
			return wp_sprintf(
				'<figure %1$s>
					<img src="%2$s" alt="%3$s" />
				</figure>',
				get_block_wrapper_attributes(),
				esc_url( trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'images/placeholder.jpg' ),
				esc_attr( $product->name )
			);
		}

		// get images and thumbnails.
		$images     = $this->getImages( $product, $attributes['width'] ?? $content_width ?? 1170 );
		$thumbnails = $this->getImages( $product, 240, [ 90, 120, 240 ] );

		// if we have more than one, show the slider.
		if ( count( $product->product_medias->data ) > 1 ) {
			return wp_sprintf(
				'<sc-image-slider
					%1$s
					product-id="%2$s"
					images=\'%3$s\'
					thumbnails=\'%4$s\'
					has-thumbnails
					thumbnails-per-page="%5$s"
					auto-height="%6$s"
					style="--sc-product-slider-height: %7$s"
				></sc-image-slider>',
				get_block_wrapper_attributes(),
				esc_attr( $product->id ),
				wp_json_encode( $images ),
				wp_json_encode( $thumbnails ),
				esc_attr( $attributes['thumbnails_per_page'] ?? 5 ),
				esc_attr( wp_validate_boolean( $attributes['auto_height'] ) ? 'true' : 'false' ),
				esc_attr( wp_validate_boolean( $attributes['auto_height'] ) ? 'auto' : ( esc_attr( $attributes['height'] ?? 'auto' ) ) )
			);
		}

		// show a single image.
		return wp_sprintf(
			'<figure %1$s>
				<img src="%2$s" alt="%3$s" title="%4$s" />
			</figure>',
			get_block_wrapper_attributes(),
			esc_url( $product->product_medias->data[0]->getUrl( 800 ) ),
			esc_attr( $product->featured_media->alt ),
			esc_attr( $product->featured_media->title )
		);
	}

	/**
	 * Get the block classes.
	 *
	 * @param \SureCart\Models\Product` $product Product object.
	 * @param integer                   $width Image width.
	 *
	 * @return array
	 */
	public function getImages( $product, $width, $srcset = [] ) {
		$width = $width ?? 1170;

		return array_map(
			function( $product_media ) use ( $product, $width ) {
				$items = [
					'src'    => esc_url( $product_media->getUrl( $width ) ),
					'alt'    => esc_attr( $product_media->media->alt ?? esc_url( $product_media->media->filename ?? $product->name ?? '' ) ),
					'title'  => $product_media->media->title ?? '',
					'width'  => $product_media->width,
					'height' => $product_media->height,
				];
				if ( ! empty( $srcset ) ) {
					$items['srcset'] = $product_media->getSrcset( $srcset );
				}
				return $items;
			},
			$product->product_medias->data
		);
	}
}
