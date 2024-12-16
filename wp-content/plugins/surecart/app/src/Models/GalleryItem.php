<?php
namespace SureCart\Models;

use ArrayAccess;
use JsonSerializable;
use SureCart\Concerns\Arrayable;
use SureCart\Concerns\Objectable;
use SureCart\Models\Traits\HasAttributes;

/**
 * GalleryItem model
 */
abstract class GalleryItem implements ArrayAccess, JsonSerializable, Arrayable, Objectable {
	use HasAttributes;

	/**
	 * The item.
	 *
	 * @var \WP_Post|\SureCart\Models\ProductMedia
	 */
	protected $item = null;

	/**
	 * Convert object to array.
	 *
	 * @return Array
	 */
	public function toArray() {
		if ( isset( $this->item->ID ) ) {
			$this->item->id = $this->item->ID;
		}
		if ( method_exists( $this->item, 'toArray' ) ) {
			return $this->item->toArray();
		}
		if ( $this->item->guid ) {
			$this->item->url = $this->item->guid;
		}
		return (array) $this->item;
	}

	/**
	 * Get the image markup.
	 *
	 * @param string $key The key to get.
	 *
	 * @return string
	 */
	public function __get( $key ) {
		// normalize the variant option.
		if ( 'variant_option' === $key && isset( $this->item->ID ) ) {
			return get_post_meta( $this->item->ID, 'sc_variant_option', true );
		}

		// normalize the ID.
		if ( 'id' === $key && isset( $this->item->ID ) ) {
			return $this->item->ID;
		}

		if ( isset( $this->item->{$key} ) ) {
			return $this->item->{$key};
		}
		return null;
	}

	/**
	 * Determine if the given attribute exists.
	 *
	 * @param  mixed $offset Name.
	 * @return bool
	 */
	public function offsetExists( $offset ): bool {
		return ! is_null( $this->item->{$offset} );
	}

	/**
	 * Get the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet( $offset ) {
		return $this->item->{$offset};
	}

	/**
	 * Set the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @param  mixed $value Value.
	 * @return void
	 */
	public function offsetSet( $offset, $value ): void {
		$this->item->{$offset} = $value;
	}

	/**
	 * Unset the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return void
	 */
	public function offsetUnset( $offset ): void {
		$this->item->{$offset} = null;
	}

	/**
	 * Determine if an attribute or relation exists on the model.
	 *
	 * @param  string $key Name.
	 * @return bool
	 */
	public function __isset( $key ) {
		// normalize the variant option.
		if ( 'variant_option' === $key && isset( $this->item->ID ) ) {
			return ! empty( get_post_meta( $this->item->ID, 'sc_variant_option', true ) );
		}

		return isset( $this->item->{$key} );
	}
}
