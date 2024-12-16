<?php

namespace SureCart\Models;

use ArrayAccess;
use JsonSerializable;
use SureCart\Concerns\Arrayable;
use SureCartVendors\PluginEver\QueryBuilder\Query;

/**
 * Model class
 */
abstract class DatabaseModel implements ArrayAccess, JsonSerializable, Arrayable, ModelInterface {
	/**
	 * Keeps track of booted models
	 *
	 * @var array
	 */
	protected static $booted = [];

	/**
	 * Keeps track of model events
	 *
	 * @var array
	 */
	protected static $events = [];

	/**
	 * Stores model attributes
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Default attributes.
	 *
	 * @var array
	 */
	protected $defaults = [];

	/**
	 * Original attributes for dirty handling
	 *
	 * @var array
	 */
	protected $original = [];

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = '';


	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = '';

	/**
	 * Query arguments
	 *
	 * @var array
	 */
	protected $query = [];

	/**
	 * Stores model relations
	 *
	 * @var array
	 */
	protected $relations = [];

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
	 * Default collection limit
	 *
	 * @var integer
	 */
	protected $limit = 20;


	/**
	 * Default collection offset.
	 *
	 * @var integer
	 */
	protected $offset = 0;

	/**
	 * The default transient cache time
	 *
	 * @var integer
	 */
	protected $transient_cache_time = 5 * MINUTE_IN_SECONDS;

	/**
	 * Holds the db class.
	 *
	 * @var \SureCartVendors\PluginEver\QueryBuilder\Query
	 */
	protected $db;

	/**
	 * The table name for the model.
	 *
	 * @var string
	 */
	protected $table_name;

	/**
	 * Total items found.
	 *
	 * @var integer
	 */
	protected $total;

	/**
	 * Model constructor
	 *
	 * @param array $attributes Optional attributes.
	 */
	public function __construct( $attributes = [] ) {
		// if we have string here, assume it's the id.
		if ( is_string( $attributes ) ) {
			$attributes = [ 'id' => $attributes ];
		}

		$this->bootModel();
		$this->syncOriginal();
		$this->fill( $attributes );
	}

	/**
	 * Get the query.
	 *
	 * @return \SureCartVendors\PluginEver\QueryBuilder\Query
	 */
	public function getQuery() {
		if ( ! $this->query ) {
			$this->query = $this->getDBInstance();
		}
		return $this->query;
	}

	/**
	 * Get the db instance.
	 *
	 * @return \SureCartVendors\PluginEver\QueryBuilder\Query
	 */
	public function getDBInstance() {
		return Query::init( $this->object_name )->select( '*' )->from( $this->table_name );
	}

	/**
	 * Sync original attributes in case of dirty needs
	 *
	 * @return Model
	 */
	public function syncOriginal() {
		$this->original = $this->attributes;
		return $this;
	}

	/**
	 * Run boot method on model
	 *
	 * @return void
	 */
	public function bootModel() {
		$called_class = static::getCalledClassName();

		if ( ! isset( static::$booted[ $called_class ] ) ) {
			static::$booted[ $called_class ] = true;
			static::boot();
		}
	}

	/**
	 * Get the called class name
	 *
	 * @return string
	 */
	public static function getCalledClassName() {
		$class = get_called_class();
		$class = explode( '\\', $class );
		end( $class );
		$last = key( $class );
		return strtolower( $class[ $last ] );
	}

	/**
	 * Model boot method
	 *
	 * @return void
	 */
	public static function boot() {
		// Note: Don't remove this method.
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
	 * Register a model event
	 *
	 * @param string   $event Event name.
	 * @param function $callback Callback function.
	 *
	 * @return void
	 */
	public static function registerModelEvent( $event, $callback ) {
		$called_class                                       = static::getCalledClassName();
		static::$events[ "model.{$called_class}.{$event}" ] = $callback;
	}

	/**
	 * Model has been retrieved
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function retrieved( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Saving (Before Save)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function saving( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Savied (After Save)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function saved( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Creating (Before Create)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function creating( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Created (After Create)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function created( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Updating (Before Updating)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function updating( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Updating (After Updating)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function updated( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Deleting (Before Deleting)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function deleting( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Model Deleted (After Deleted)
	 *
	 * @param function $callback Callback method.
	 *
	 * @return void
	 */
	public static function deleted( $callback ) {
		static::registerModelEvent( __FUNCTION__, $callback );
	}

	/**
	 * Fires the model event.
	 *
	 * @param string $event Event name.
	 *
	 * @return mixed
	 */
	public function fireModelEvent( $event ) {
		$called_class = static::getCalledClassName();
		$event_name   = "model.{$called_class}.{$event}";

		// fire global event.
		\do_action( "surecart/models/{$called_class}/{$event}", $this );

		if ( isset( static::$events[ $event_name ] ) ) {
			return call_user_func( static::$events[ $event_name ], $this );
		}
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
			} elseif ( $this->isFillable( $key ) ) {
					$this->setAttribute( $key, maybe_unserialize( maybe_unserialize( $value ) ) );
			}
		}

		return apply_filters( "surecart/{$this->object_name}/set_attributes", $this );
	}

	/**
	 * Make sure ID is always int.
	 *
	 * @param mixed $value Id.
	 *
	 * @return void
	 */
	public function setIdAttribute( $value ) {
		$this->attributes['id'] = (int) $value;
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
	 * Get fillable items
	 *
	 * @return array
	 */
	public function getFillable() {
		return $this->fillable;
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
	 * Build query query
	 *
	 * @param array $query Arguments.
	 *
	 * @return Model
	 */
	protected function with( $query = [] ) {
		$this->query['expand'] = (array) array_merge( $query, $this->query['expand'] ?? [] );
		return $this;
	}

	/**
	 * Set the request mode (test or live).
	 *
	 * @param 'test'|'live' $mode Request mode.
	 */
	public function setMode( $mode ) {
		$this->mode = $mode;
		return $this;
	}

	/**
	 * Get the current mode.
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * Set the pagination args.
	 *
	 * @param array $args Pagination args.
	 * @return $this
	 */
	protected function setPagination( $args ) {
		$args = wp_parse_args(
			$args,
			[
				'page'     => 1,
				'per_page' => 20,
			]
		);

		$this->query = $this->getQuery();

		$size   = (int) $args['per_page'];
		$limit  = (int) $size;
		$offset = (int) $size * ( ( (int) $args['page'] ) - 1 );

		$this->query->limit( $offset, $limit );

		return $this;
	}

	/**
	 * Fetch a list of items
	 *
	 * @return array|\WP_Error;
	 */
	protected function get() {
		$this->query = $this->getQuery();
		$result      = $this->query->get();
		$models      = [];
		foreach ( $result as $data ) {
			$models[] = new static( $data );
		}
		return $models;
	}

	/**
	 * Paginate results
	 *
	 * @param array $args Pagination args.
	 * @return mixed
	 */
	protected function paginate( $args = [] ) {
		$this->setPagination( $args );
		return $this->get();
	}

	/**
	 * Get the first item in the query
	 */
	public function first() {
		$this->query = $this->getQuery();
		$result      = $this->query->one();
		return $result ? new static( $result ) : null;
	}

	/**
	 * Find a specific model with and id
	 *
	 * @param string $id Id of the model.
	 *
	 * @return $this
	 */
	protected function find( $id = '' ) {
		if ( $this->fireModelEvent( 'finding' ) === false ) {
			return false;
		}

		$attributes = $this->getQuery()->find( $id, 'id' );
		if ( ! $attributes ) {
			return new \WP_Error( 'not_found', 'This does not exist.' );
		}

		$this->fireModelEvent( 'found' );
		$this->syncOriginal();
		$this->fill( $attributes );

		return $this;
	}

	/**
	 * Is the response an Error?
	 *
	 * @param Array|\WP_Error|\WP_REST_Response $response Response from request.
	 *
	 * @return boolean
	 */
	public function isError( $response ) {
		return is_wp_error( $response ) || ( $response instanceof \WP_REST_Response && ! in_array( $response->get_status(), [ 200, 201 ], true ) );
	}

	/**
	 * Get fresh instance from DB.
	 *
	 * @return this
	 */
	protected function fresh() {
		if ( ! $this->attributes['id'] ) {
			return $this;
		}
		return $this->find( $this->attributes['id'] );
	}

	/**
	 * Get fresh instance from DB.
	 *
	 * @return this
	 */
	protected function refresh() {
		if ( ! $this->attributes['id'] ) {
			return $this;
		}

		$attributes = $this->fresh();

		if ( is_wp_error( $attributes ) ) {
			return $attributes;
		}

		$this->syncOriginal();
		$this->fill( $attributes );

		return $this;
	}

	/**
	 * Save model
	 *
	 * @return $this|false
	 */
	protected function save() {
		if ( $this->fireModelEvent( 'saving' ) === false ) {
			return false;
		}

		// update or create.
		if ( $this->id ) {
			$saved = $this->isDirty() ? $this->update() : true;
		} else {
			$saved = $this->create();
		}

		if ( is_wp_error( $saved ) ) {
			return $saved;
		}

		$this->fireModelEvent( 'saved' );

		$this->syncOriginal();

		return $saved;
	}

	/**
	 * Create a new model
	 *
	 * @param array $attributes Attributes to create.
	 *
	 * @return $this|false
	 */
	protected function create( $attributes = [] ) {
		if ( $this->fireModelEvent( 'creating' ) === false ) {
			return false;
		}

		if ( $attributes ) {
			$this->syncOriginal();
			$this->fill( $attributes );
		}

		$id = $this->getQuery()->insert(
			array_merge(
				[ 'created_at' => current_time( 'mysql' ) ],
				array_map(
					function ( $item ) {
						return maybe_serialize( $item );
					},
					$this->attributes
				)
			)
		);
		if ( ! $id ) {
			return new \WP_Error( 'could_not_create', 'Could not create.' );
		}

		// bail if error.
		$created = $this->getQuery()->find( $id, 'id' );
		if ( ! $created ) {
			return new \WP_Error( 'could_not_create', 'Could not create.' );
		}

		// reset.
		$this->resetAttributes();

		// fill.
		$this->fill( $created ?? [] );

		// fire event.
		$this->fireModelEvent( 'created' );

		return $this;
	}

	/**
	 * Update the model.
	 *
	 * @return $this|false
	 */
	protected function update( $attributes = [] ) {
		if ( $this->fireModelEvent( 'updating' ) === false ) {
			return false;
		}

		if ( $attributes ) {
			$this->syncOriginal();
			$this->fill( $attributes );
		}

		$attributes = $this->attributes;
		unset( $attributes['id'] );

		$item = $this->first();
		if ( is_wp_error( $item ) ) {
			return $item;
		}

		$update = $this->getQuery()->where( 'id', $item->id )->update(
			array_merge(
				[ 'updated_at' => current_time( 'mysql' ) ],
				array_map(
					function ( $item ) {
						return maybe_serialize( $item );
					},
					$attributes
				)
			)
		);
		if ( false === $update ) {
			return new \WP_Error( 'could_not_update', 'Could not update.' );
		}

		// bail if error.
		$updated = $this->getDBInstance()->find( $item->id, 'id' );
		if ( ! $updated ) {
			return new \WP_Error( 'could_not_update', 'Could not update. id:' . $item->id );
		}

		$this->resetAttributes();

		$this->fill( $updated );

		$this->fireModelEvent( 'updated' );

		return $this;
	}

	/**
	 * Delete the model.
	 *
	 * @return $this|false
	 */
	protected function delete( $id = 0 ) {
		$id = $id ? $id : $this->id;

		if ( $this->fireModelEvent( 'deleting' ) === false ) {
			return false;
		}

		$delete = $this->getQuery();

		// deleting a single.
		if ( $id ) {
			$delete = $delete->where( 'ID', $id );
		}

		// delete.
		$deleted = $delete->delete();

		if ( false === $deleted ) {
			return new \WP_Error( 'could_not_delete', 'Could not delete.' );
		}

		$this->fireModelEvent( 'deleted' );

		return $deleted;
	}

	/**
	 * Delete all items.
	 *
	 * @return $this|false
	 */
	protected function deleteAll() {
		$delete  = $this->getQuery();
		$deleted = $delete->delete();
		if ( false === $deleted ) {
			return new \WP_Error( 'could_not_delete', 'Could not delete.' );
		}
		return $deleted;
	}

	/**
	 * Set a model relation.
	 *
	 * @prop string $attribute Attribute name.
	 * @prop string $value     Value to set.
	 * @prop string $model   Model name.
	 * @return void
	 */
	public function setRelation( $attribute, $value, $model ) {
		if ( $value ) {
			$this->attributes[ $attribute ] = is_string( $value ) ? $value : new $model( $value );
		}
	}

	/**
	 * Get a relation id.
	 *
	 * @prop string $attribute Attribute name.
	 * @prop string $value     Value to set.
	 * @prop string $model   Model name.
	 * @return string|null;
	 */
	public function getRelationId( $attribute ) {
		$value = $this->attributes[ $attribute ] ?? null;
		return ! empty( $value['id'] ) ? $value['id'] : $value;
	}

	/**
	 * Set a model collection.
	 *
	 * @prop string $attribute Attribute name.
	 * @prop string $value     Value to set.
	 * @prop string $model   Model name.
	 * @return void
	 */
	public function setCollection( $attribute, $collection, $model ) {
		$models = [];
		if ( ! empty( $collection->data ) && is_array( $collection->data ) ) {
			foreach ( $collection->data as $attributes ) {
				$models[] = new $model( $attributes );
			}
			$collection->data = $models;
		}
		$this->attributes[ $attribute ] = $collection;
	}

	/**
	 * Get the model attributes
	 *
	 * @return array
	 */
	public function getAttributes() {
		return json_decode( wp_json_encode( array_merge( $this->attributes, [ 'object' => $this->object_name ] ) ), true );
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
	 * Serialize to json.
	 *
	 * @return Array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return $this->toArray();
	}

	/**
	 * Calls accessors during toArray.
	 *
	 * @return array
	 */
	public function toArray() {
		$attributes = $this->getAttributes();

		// Check if any accessor is available and call it.
		foreach ( get_class_methods( $this ) as $method ) {
			if ( method_exists( get_class( $this ), $method ) ) {
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
			function ( &$value, $key ) {
				if ( $value instanceof Model ) {
					$value = $value->toArray();
				}
			}
		);

		return array_merge( $attributes, $this->relations );
	}

	/**
	 * Is the model dirty (has unsaved items)
	 *
	 * @param array $attributes Optionally pass attributes to check.
	 *
	 * @return boolean
	 */
	public function isDirty( $attributes = null ) {
		$dirty = $this->getDirty();

		if ( is_null( $attributes ) ) {
			return count( $dirty ) > 0;
		}

		if ( ! is_array( $attributes ) ) {
			$attributes = func_get_args();
		}

		foreach ( $attributes as $attribute ) {
			if ( array_key_exists( $attribute, $dirty ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get dirty (unsaved) items
	 *
	 * @return array
	 */
	public function getDirty() {
		$dirty = [];

		foreach ( $this->attributes as $key => $value ) {
			if ( ! array_key_exists( $key, $this->original ) ) {
				$dirty[ $key ] = $value;
			} elseif ( $value !== $this->original[ $key ] &&
				! $this->originalIsNumericallyEquivalent( $key ) ) {
				$dirty[ $key ] = $value;
			}
		}

		return $dirty;
	}

	/**
	 * Determine if the new and old values for a given key are numerically equivalent.
	 *
	 * @param  string $key Attribute name.
	 * @return bool
	 */
	protected function originalIsNumericallyEquivalent( $key ) {
		$current  = $this->attributes[ $key ];
		$original = $this->original[ $key ];
		return is_numeric( $current ) && is_numeric( $original ) && strcmp( (string) $current, (string) $original ) === 0;
	}

	/**
	 * Get the original item
	 *
	 * @param string $key Name of the item.
	 *
	 * @return mixed
	 */
	public function getOriginal( $key = null ) {
		if ( ! is_null( $key ) ) {
			return isset( $this->original[ $key ] ) ? $this->original[ $key ] : null;
		}
		return $this->original;
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
		unset( $this->attributes[ $offset ], $this->relations[ $offset ] );
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

	/**
	 * Forward call to method
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 */
	public function __call( $method, $params ) {
		// if we have the method.
		if ( method_exists( $this, $method ) ) {
			return call_user_func_array( [ $this, $method ], $params );
		}
		// if the query builder has a method, start building query.
		if ( method_exists( Query::class, $method ) ) {
			$result = $this->getQuery()->{$method}( ...$params );
			if ( in_array( $method, [ 'count' ] ) ) {
				return $result;
			}
			return $this;
		}
	}

	/**
	 * Static Facade Accessor
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $params ) {
		// if we have the method.
		if ( method_exists( static::class, $method ) ) {
			return call_user_func_array( [ new static(), $method ], $params );
		}

		// if the query builder has a method, start building query.
		if ( method_exists( Query::class, $method ) ) {
			$item   = new static();
			$result = $item->getQuery()->{$method}( ...$params );
			if ( in_array( $method, [ 'count' ] ) ) {
				return $result;
			}
			return $item;
		}
	}
}
