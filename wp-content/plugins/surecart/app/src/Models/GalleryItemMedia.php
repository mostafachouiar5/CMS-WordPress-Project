<?php
namespace SureCart\Models;

use SureCart\Models\GalleryItem as ModelsGalleryItem;
use SureCart\Support\Contracts\GalleryItem;

/**
 * Gallery item model
 */
class GalleryItemMedia extends ModelsGalleryItem implements GalleryItem {
	/**
	 * Create a new gallery item.
	 * This can accept a product media or a post.
	 *
	 * @param \SureCart\Models\Media $item The item.
	 *
	 * @return void
	 */
	public function __construct( \SureCart\Models\Media $item ) {
		$this->item = $item;
	}

	/**
	 * Get the media attribute markup.
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return string
	 */
	public function html( $size = 'full', $attr = [] ): string {
		return $this->item->html( $size, $attr );
	}

	/**
	 * Get the image data.
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return array
	 */
	public function attributes( $size = 'full', $attr = [] ) {
		return $this->item->attributes( $size, $attr );
	}
}
