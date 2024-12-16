<?php

namespace SureCart\Models\Traits;

/**
 * If the model has an attached customer.
 */
trait HasImageSizes {
	/**
	 * Sizes.
	 *
	 * @var array
	 */
	protected $image_sizes = [
		320,
		640,
		960,
		1280,
		1920,
	];

	/**
	 * Options.
	 *
	 * @var array
	 */
	protected $resize_options = [
		'fit=scale-down',
		'format=auto',
	];

	/**
	 * Set the image sizes.
	 *
	 * @param array $sizes Image sizes.
	 *
	 * @return $this
	 */
	public function withImageSizes( $sizes ) {
		$this->image_sizes = $sizes;
		return $this;
	}

	/**
	 * Set the image resize options.
	 *
	 * @param array $options Image resize options.
	 *
	 * @return $this
	 */
	public function withResizeOptions( $options ) {
		$this->resize_options = $options;
		return $this;
	}

	/**
	 * Get the URL.
	 *
	 * @param string  $url The full url to the image.
	 * @param integer $size The size to use.
	 * @param boolean $append_width Append the width to the url.
	 *
	 * @return string
	 */
	public function imageUrl( $url, $size, $append_width = false, $additional_options = '' ) {
		$start = "https://surecart.com/cdn-cgi/image/{$this->getResizeOptions()},width=$size" . ( ! empty( $additional_options ) ? ",$additional_options," : '' );
		$url   = "$start/$url";
		if ( $append_width ) {
			$url .= " $size" . 'w';
		}
		return $url;
	}

	/**
	 * Get the image srcset.
	 *
	 * @param string $url The full url to the image.
	 *
	 * @return string
	 */
	public function imageSrcSet( $url, $image_sizes = [] ) {
		$image_sizes = empty( $image_sizes ) ? $this->getImageSizes() : $image_sizes;
		$sizes       = [];
		foreach ( $image_sizes as $size ) {
			$sizes[] = $this->imageUrl( $url, $size, true );
		}
		return implode( ', ', $sizes );
	}

	/**
	 * Get the image_sizes
	 *
	 * @return array
	 */
	public function getImageSizes() {
		return apply_filters( 'surecart/default_image_sizes', $this->image_sizes, $this );
	}

	/**
	 * Get the image options.
	 *
	 * @return string
	 */
	public function getResizeOptions() {
		return implode(
			',',
			apply_filters( 'surecart/image_resize_options', $this->resize_options, $this )
		);
	}
}
