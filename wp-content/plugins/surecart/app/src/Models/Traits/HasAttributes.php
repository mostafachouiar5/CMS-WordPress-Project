<?php

namespace SureCart\Models\Traits;

trait HasAttributes {
	/**
	 * Keeps track of booted models
	 *
	 * @var array
	 */
	protected static $booted = [];

	/**
	 * Stores model attributes
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Fillable model items
	 *
	 * @var array
	 */
	protected $fillable = [ '*' ];

	/**
	 * Guarded model items
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Model constructor
	 *
	 * @param array $attributes Optional attributes.
	 */
	public function __construct( $attributes = [] ) {
		// if we have string here, assume it's the id.
		if ( is_string( $attributes ) || is_int( $attributes ) ) {
			$attributes = [ 'id' => $attributes ];
		}
		$this->fill( $attributes );
	}

	/**
	 * Get fillable items
	 *
	 * @return array
	 */
	public function getFillable() {
		return $this->fillable;
	}

	/**
	 * Is the attribute fillable?
	 *
	 * @param string $key Attribute name.
	 *
	 * @return boolean
	 */
	public function isFillable( $key ) {
		$fillable = $this->getFillable();

		if ( in_array( $key, $fillable, true ) ) {
			return true;
		}

		if ( $this->isGuarded( $key ) ) {
			return false;
		}

		return ! empty( $fillable ) && '*' === $fillable[0];
	}

	/**
	 * Sets attributes in model
	 *
	 * @param array $attributes Attributes to fill.
	 *
	 * @return Model
	 */
	public function fill( $attributes ) {
		return $this->setAttributes( $attributes );
	}

	/**
	 * Get guarded items
	 *
	 * @return array
	 */
	public function getGuarded() {
		return $this->guarded;
	}

	/**
	 * Is the key guarded
	 *
	 * @param string $key Name of the attribute.
	 *
	 * @return boolean
	 */
	public function isGuarded( $key ) {
		$guarded = $this->getGuarded();
		return in_array( $key, $guarded, true ) || [ '*' ] === $guarded;
	}

	/**
	 * Reset attributes to blank.
	 *
	 * @return $this
	 */
	public function resetAttributes() {
		$this->attributes = [];
		return $this;
	}

	/**
	 * Set model attributes
	 *
	 * @param array   $attributes Attributes to add.
	 * @param boolean $is_guarded Use guarded.
	 *
	 * @return Model
	 */
	public function setAttributes( $attributes, $is_guarded = true ) {
		if ( empty( $attributes ) ) {
			return $this;
		}

		foreach ( $attributes as $key => $value ) {
			// remove api attributes.
			if ( in_array( $key, [ '_locale', 'rest_route' ], true ) ) {
				continue;
			}

			// set attribute.
			if ( ! $is_guarded ) {
				$this->setAttribute( $key, maybe_unserialize( maybe_unserialize( $value ) ) );
			} else {
				if ( $this->isFillable( $key ) ) {
					$this->setAttribute( $key, maybe_unserialize( maybe_unserialize( $value ) ) );
				}
			}
		}

		return apply_filters( 'surecart/set_attributes', $this );
	}

	/**
	 * Sets an attribute
	 * Optionally calls a mutator based on set{Attribute}Attribute
	 *
	 * @param string $key Attribute key.
	 * @param mixed  $value Attribute value.
	 *
	 * @return mixed|void
	 */
	public function setAttribute( $key, $value ) {
		$setter = $this->getMutator( $key, 'set' );

		if ( $setter ) {
			return $this->{$setter}( $value );
		} else {
			$this->attributes[ $key ] = $value;
		}
	}

	/**
	 * Does it have the attribute
	 *
	 * @param string $key Attribute key.
	 *
	 * @return boolean
	 */
	public function hasAttribute( $key ) {
		return array_key_exists( $key, $this->attributes );
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
			$attribute = $this->attributes[ $key ];
		}

		$getter = $this->getMutator( $key, 'get' );

		if ( $getter ) {
			return $this->{$getter}( $attribute );
		} elseif ( ! is_null( $attribute ) ) {
			return $attribute;
		}
	}

	/**
	 * Calls a mutator based on set{Attribute}Attribute
	 *
	 * @param string $key Attribute key.
	 * @param mixed  $type 'get' or 'set'.
	 *
	 * @return string|false
	 */
	public function getMutator( $key, $type ) {
		$key = ucwords( str_replace( [ '-', '_' ], ' ', $key ) );

		$method = $type . str_replace( ' ', '', $key ) . 'Attribute';

		if ( method_exists( $this, $method ) ) {
			return $method;
		}

		return false;
	}

	/**
	 * Get the attributes
	 *
	 * @return array
	 */
	public function getAttributes() {
		return json_decode( wp_json_encode( $this->attributes ), true );
	}

	/**
	 * Convert to object.
	 *
	 * @return Object
	 */
	public function toObject() {
		$attributes = (object) $this->attributes;

		// Check if any accessor is available and call it.
		foreach ( get_class_methods( $this ) as $method ) {
			if ( method_exists( get_class(), $method ) ) {
				continue;
			}

			if ( 'get' === substr( $method, 0, 3 ) && 'Attribute' === substr( $method, -9 ) ) {
				$key = str_replace( [ 'get', 'Attribute' ], '', $method );
				if ( $key ) {
					$pieces           = preg_split( '/(?=[A-Z])/', $key );
					$pieces           = array_map( 'strtolower', array_filter( $pieces ) );
					$key              = implode( '_', $pieces );
					$value            = array_key_exists( $key, $this->attributes ) ? $this->attributes[ $key ] : null;
					$attributes->$key = $this->{$method}( $value );
				}
			}
		}

		// Check if any attribute is a model and call toArray.
		array_walk_recursive(
			$attributes,
			function ( &$value ) {
				if ( method_exists( $value, 'toObject' ) ) {
					$value = $value->toObject();
				}
			}
		);

		return $attributes;
	}

	/**
	 * Calls accessors during toArray.
	 *
	 * @return Array
	 */
	public function toArray() {
		$attributes = $this->getAttributes();

		// Check if any accessor is available and call it.
		foreach ( get_class_methods( $this ) as $method ) {
			if ( method_exists( get_class(), $method ) ) {
				continue;
			}

			if ( 'get' === substr( $method, 0, 3 ) && 'Attribute' === substr( $method, -9 ) ) {
				$key = str_replace( [ 'get', 'Attribute' ], '', $method );
				if ( $key ) {
					$pieces             = preg_split( '/(?=[A-Z])/', $key );
					$pieces             = array_map( 'strtolower', array_filter( $pieces ) );
					$key                = implode( '_', $pieces );
					$value              = array_key_exists( $key, $this->attributes ) ? $this->attributes[ $key ] : null;
					$attributes[ $key ] = $this->{$method}( $value );
				}
			}
		}

		// Check if any attribute is a model and call toArray.
		array_walk_recursive(
			$attributes,
			function ( &$value ) {
				if ( method_exists( $value, 'toArray' ) ) {
					$value = $value->toArray();
				}
			}
		);

		return $attributes;
	}

	/**
	 * Serialize to json.
	 *
	 * @return Array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return $this->toArray();
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
	#[\ReturnTypeWillChange]
	public function offsetExists( $offset ) {
		return ! is_null( $this->getAttribute( $offset ) );
	}

	/**
	 * Get the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
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
	#[\ReturnTypeWillChange]
	public function offsetSet( $offset, $value ) {
		$this->setAttribute( $offset, $value );
	}

	/**
	 * Unset the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	public function offsetUnset( $offset ) {
		unset( $this->attributes[ $offset ] );
	}

	/**
	 * Determine if an attribute or relation exists on the model.
	 *
	 * @param  string $key Name.
	 * @return bool
	 */
	public function __isset( $key ) {
		return $this->offsetExists( $key );
	}

	/**
	 * Unset an attribute on the model.
	 *
	 * @param  string $key Name.
	 * @return void
	 */
	public function __unset( $key ) {
		$this->offsetUnset( $key );
	}
}
