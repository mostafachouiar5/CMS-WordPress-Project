<?php

namespace SureCart\Support\Contracts;

interface GalleryItem {
	/**
	 * Get the page title attribute.
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return string
	 */
	public function html( $size = 'full', $attr = [] ) : string;

	/**
	 * Get the page descriptoin attribute
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return string
	 */
	public function attributes( $size = 'full', $attr = [] );
}
