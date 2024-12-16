<?php

namespace SureCart\Models;

/**
 * Price model
 */
class Media extends Model {
	use Traits\HasImageSizes;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'medias';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'media';

	/**
	 * Image srcset.
	 *
	 * @return string
	 */
	public function getSrcsetAttribute() {
		if ( empty( $this->attributes['url'] ) ) {
			return '';
		}
		return $this->imageSrcSet( $this->attributes['url'] );
	}

	/**
	 * Get the image url for a specific size.
	 *
	 * @param integer $size The size.
	 *
	 * @return string
	 */
	public function getUrl( $size = 0 ) {
		if ( empty( $this->attributes['url'] ) ) {
			return '';
		}
		return $size ? $this->imageUrl( $this->attributes['url'], $size ) : $this->attributes['url'];
	}

	/**
	 * Get the image markup.
	 * We are assuming all media here is an image.
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return string
	 */
	protected function html( $size = 'full', $attr = [] ) {
		// prepare attributes.
		$attr = $this->attributes( $size, $attr );
		$html = '<img ';

		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}

		// close tag.
		$html .= ' />';

		return $html;
	}

	/**
	 * Get the image attributes.
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return array
	 */
	protected function attributes( $size = 'full', $attr = [] ) {
		// get sizes.
		$sizes      = wp_get_registered_image_subsizes();
		$image_size = $sizes[ $size ] ?? null;

		// get width and constrain the dimensions based on the width/height.
		$width = $image_size['width'] ?? $this->width ?? 1080;
		if ( $this->width && $this->height ) {
			[$width, $height] = wp_constrain_dimensions( $this->width, $this->height, $width );
		} else {
			$height = $image_size['height'] ?? $this->height ?? 1080;
		}

		$srcset_sizes = array_map(
			function ( $size ) {
				return $size['width'];
			},
			$sizes
		);

		$attachment_class = 'attachment-' . $size . ' size-' . $size;

		// set attributes.
		$attr['src']    = $this->getUrl( $width );
		$attr['alt']    = $this->alt ?? '';
		$attr['class']  = $attachment_class . ' ' . ( ! empty( $attr['class'] ) ? $attr['class'] : '' );
		$attr['sizes']  = sprintf( '(max-width: %1$dpx) 100vw, %1$dpx', $width );
		$attr['width']  = (int) $width;
		$attr['height'] = (int) $height;

		// loading attributes.
		$loading_attr              = $attr;
		$loading_attr['width']     = $width;
		$loading_attr['height']    = $height;
		$loading_optimization_attr = wp_get_loading_optimization_attributes(
			'img',
			$loading_attr,
			'surecart-product-page'
		);

		// Add loading optimization attributes if not available.
		$attr = array_merge( $attr, $loading_optimization_attr );

		// Omit the `decoding` attribute if the value is invalid according to the spec.
		if ( empty( $attr['decoding'] ) || ! in_array( $attr['decoding'], array( 'async', 'sync', 'auto' ), true ) ) {
			unset( $attr['decoding'] );
		}

		/*
		* If the default value of `lazy` for the `loading` attribute is overridden
		* to omit the attribute for this image, ensure it is not included.
		*/
		if ( isset( $attr['loading'] ) && ! $attr['loading'] ) {
			unset( $attr['loading'] );
		}

		// If the `fetchpriority` attribute is overridden and set to false or an empty string.
		if ( isset( $attr['fetchpriority'] ) && ! $attr['fetchpriority'] ) {
			unset( $attr['fetchpriority'] );
		}

		if ( empty( $attr['srcset'] ) ) {
			$attr['srcset'] = $this->imageSrcSet( $this->url, $srcset_sizes );
		}

		/**
		 * Filters the list of attachment image attributes.
		 *
		 * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
		 *                                 See wp_get_attachment_image().
		 * @param \SureCart\Models\ProductMedia      $this   The current instance of the ProductMedia class.
		 * @param string|int[] $size       Requested image size. Can be any registered image size name, or
		 *                                 an array of width and height values in pixels (in that order).
		 */
		$attr = apply_filters( 'wp_get_sc_product_attachment_image_attributes', $attr, $this, $size );

		// prepare attributes.
		return (object) $attr;
	}
}
