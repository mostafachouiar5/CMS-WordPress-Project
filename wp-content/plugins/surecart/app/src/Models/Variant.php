<?php

namespace SureCart\Models;

use SureCart\Support\Currency;

/**
 * Variant model
 */

class Variant extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'variants';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'variant';

	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setProductAttribute( $value ) {
		$this->setRelation( 'product', $value, Product::class );
	}

	/**
	 * Set the image attribute
	 *
	 * @param  string $value Image properties.
	 * @return void
	 */
	public function setImageAttribute( $value ) {
		$this->setRelation( 'image', $value, Media::class );
	}

	/**
	 * Get the display amount attribute
	 *
	 * @return string
	 */
	public function getDisplayAmountAttribute() {
		return empty( $this->amount ) ? '' : Currency::format( $this->amount, $this->currency );
	}

	/**
	 * Get the featured image attribute.
	 *
	 * @return object
	 */
	public function getLineItemImageAttribute() {
		// we have wp media.
		if ( ! empty( $this->metadata->wp_media ) ) {
			$item = new GalleryItemAttachment( $this->metadata->wp_media );
			return $item->attributes( 'thumbnail' );
		}

		// we have a fallback model from the platform.
		if ( is_a( $this->image, \SureCart\Models\Media::class ) ) {
			return $this->image->attributes( 'thumbnail' );
		}

		// always return an empty object.
		return (object) [];
	}
}
