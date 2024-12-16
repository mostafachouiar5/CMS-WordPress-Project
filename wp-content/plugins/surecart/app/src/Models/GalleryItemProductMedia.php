<?php
namespace SureCart\Models;

use SureCart\Models\GalleryItem as ModelsGalleryItem;
use SureCart\Support\Contracts\GalleryItem;

/**
 * Gallery item model
 */
class GalleryItemProductMedia extends ModelsGalleryItem implements GalleryItem {
	/**
	 * Create a new gallery item.
	 * This can accept a product media or a post.
	 *
	 * @param \SureCart\Models\ProductMedia $item The item.
	 *
	 * @return void
	 */
	public function __construct( \SureCart\Models\ProductMedia $item ) {
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
	public function html( $size = 'full', $attr = array() ): string {
		$image = '';

		// Handle media.
		if ( isset( $this->item->media ) ) {
			return $this->item->media->html( $size, $attr );
		}

		// Handle media url.
		if ( isset( $this->item->url ) ) {
			$attributes = $this->attributes( $size, $attr );

			// build the image tag.
			$image = '<img';
			foreach ( $attributes as $key => $value ) {
				$image .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );
			}
			$image .= ' />';
		}

		// add any styles.
		$tags = new \WP_HTML_Tag_Processor( $image );

		// add inline styles.
		if ( ! empty( $attr['style'] ) ) {
			if ( $tags->next_tag( 'img' ) && ! empty( $attr['style'] ) ) {
				$tags->set_attribute( 'style', $attr['style'] );
			}
		}

		// return updated html.
		return $tags->get_updated_html();
	}

	/**
	 * Get the image data.
	 *
	 * @param string $size The size of the image.
	 * @param array  $attr The attributes for the tag.
	 *
	 * @return array
	 */
	public function attributes( $size = 'full', $attr = array() ) {
		if ( isset( $this->item->media ) ) {
			return $this->item->media->attributes( $size, $attr );
		}

		$attachment_class = 'attachment-' . $size . ' size-' . $size;

		return (object) array(
			'src'   => $this->item->url,
			'class' => $attachment_class . ' ' . ( ! empty( $attr['class'] ) ? $attr['class'] : '' ),
			'alt'   => get_the_title(),
		);
	}
}
