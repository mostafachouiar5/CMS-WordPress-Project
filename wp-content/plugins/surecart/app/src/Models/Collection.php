<?php
namespace SureCart\Models;

/**
 * Stores a collection of items.
 */
class Collection {
	/**
	 * Keeps track of booted models
	 *
	 * @var array
	 */
	protected static $booted = [];

	/**
	 * Stores the collection data
	 *
	 * @var StdClass
	 */
	protected $attributes;

	/**
	 * Model constructor
	 *
	 * @param object $collection Optional attributes.
	 */
	public function __construct( $collection ) {
		$this->attributes = (object) $collection;
	}

	/**
	 * Get the called class name
	 *
	 * @return string
	 */
	public static function getCalledClassName() {
		return str_replace( '\\', '_', get_called_class() );
	}

	/**
	 * Get the total.
	 *
	 * @return string
	 */
	public function total() {
		return $this->pagination->count ?? 0;
	}

	/**
	 * Get the total pages.
	 *
	 * @return string
	 */
	public function totalPages() {
		return ceil( ( $this->pagination->count ?? 0 ) / ( $this->pagination->limit ?? 1 ) );
	}

	/**
	 * Does this collection have a next page?
	 *
	 * @return boolean
	 */
	public function hasNextPage() {
		$seen = $this->pagination->page * $this->pagination->limit;
		return $this->pagination->count > $seen;
	}

	/**
	 * Does this collection have a previous page?
	 *
	 * @return boolean
	 */
	public function hasPreviousPage() {
		return $this->pagination->page > 1;
	}

	/**
	 * Get a specific attribute
	 *
	 * @param string $key Attribute name.
	 *
	 * @return mixed
	 */
	public function getAttribute( $key ) {
		$attribute = null;

		if ( $this->hasAttribute( $key ) ) {
			$attribute = $this->attributes->$key;
		}

		return $attribute;
	}

	/**
	 * Does it have the attribute
	 *
	 * @param string $key Attribute key.
	 *
	 * @return boolean
	 */
	public function hasAttribute( $key ) {
		return property_exists( $this->attributes, $key );
	}

	/**
	 * Get the attribute
	 *
	 * @param string $key Attribute name.
	 *
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->getAttribute( $key );
	}

	/**
	 * Set the attribute
	 *
	 * @param string $key Attribute name.
	 * @param mixed  $value Value of attribute.
	 *
	 * @return void
	 */
	public function __set( $key, $value ) {
		$this->setAttribute( $key, $value );
	}

	/**
	 * Determine if the given attribute exists.
	 *
	 * @param  mixed $offset Name.
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return ! is_null( $this->getAttribute( $offset ) );
	}

	/**
	 * Get the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return mixed
	 */
	public function offsetGet( $offset ) {
		return $this->getAttribute( $offset );
	}

	/**
	 * Set the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @param  mixed $value Value.
	 * @return void
	 */
	public function offsetSet( $offset, $value ) {
		$this->setAttribute( $offset, $value );
	}

	/**
	 * Forward call to method
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 */
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this, $method ], $params );
	}
}
