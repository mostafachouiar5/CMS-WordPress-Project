<?php

namespace SureCart\Models;

use ArrayAccess;
use JsonSerializable;
use SureCart\Concerns\Arrayable;
use SureCart\Concerns\Objectable;

/**
 * Model class
 */
abstract class Model implements ArrayAccess, JsonSerializable, Arrayable, Objectable, ModelInterface {
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
	 * Static cache for attribute lookups.
	 *
	 * @var array
	 */
	private static $attribute_cache = [];

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
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cachable = false;

	/**
	 * Is this cachable?
	 *
	 * @var boolean
	 */
	protected $cache_key = '';

	/**
	 * Cache status for the request.
	 *
	 * @var string|null;
	 */
	protected $cache_status = null;

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = false;

	/**
	 * Model constructor
	 *
	 * @param array $attributes Optional attributes.
	 */
	public function __construct( $attributes = [] ) {
		// filter meta data setting.
		add_filter( "surecart/$this->object_name/set_meta_data", [ $this, 'filterMetaData' ], 9 );

		// if we have string here, assume it's the id.
		if ( is_string( $attributes ) ) {
			$attributes = [ 'id' => $attributes ];
		}

		$this->bootModel();
		$this->syncOriginal();
		$this->fill( $attributes );
	}

	/**
	 * Get the object name
	 *
	 * @return string
	 */
	protected function getObjectName() {
		return $this->object_name;
	}

	/**
	 * Get the cache status for the model.
	 *
	 * @return string|null;
	 */
	public function getCacheStatus() {
		return $this->cache_status;
	}

	/**
	 * Get the query.
	 *
	 * @return array
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Filter meta data setting
	 *
	 * @param object $meta_data Meta data.
	 *
	 * @return function
	 */
	public function filterMetaData( $meta_data ) {
		return $meta_data;
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
			// allow filtering attribute.
			$value = apply_filters( "surecart/{$this->object_name}/set_attribute", $value, $key, $this );

			// remove api attributes.
			if ( in_array( $key, [ '_locale', 'rest_route' ], true ) ) {
				continue;
			}

			// set attribute.
			if ( ! $is_guarded ) {
				$this->setAttribute( $key, $value );
			} elseif ( $this->isFillable( $key ) ) {
					$this->setAttribute( $key, $value );
			}
		}

		// Do an action.
		do_action( "surecart/{$this->object_name}/attributes_set", $this );

		return $this;
	}

	/**
	 * Get the metadata attribute.
	 * This makes sure the metadata is always an object.
	 *
	 * @return object
	 */
	public function getMetadataAttribute() {
		return (object) ( $this->attributes['metadata'] ?? [] );
	}

	/**
	 * Get the person who created it.
	 *
	 * @return int|false
	 */
	public function getCreatedByAttribute() {
		if ( empty( $this->metadata->wp_created_by ) ) {
			return false;
		}

		return (int) $this->metadata->wp_created_by;
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
		// we are setting the cache status.
		if ( 'cache_status' === $key ) {
			$this->cache_status = $value;
			return;
		}

		$setter = $this->getMutator( $key, 'set' );

		if ( $setter ) {
			return $this->{$setter}( $value );
		} else {
			$this->attributes[ $key ] = apply_filters( "surecart/$this->object_name/attributes/$key", $value, $this );
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
	 * Set the meta data attribute.
	 *
	 * @param array $meta_data Model meta data.
	 *
	 * @return self
	 */
	public function setMetadataAttribute( $meta_data ) {
		$this->attributes['metadata'] = (object) apply_filters( "surecart/$this->object_name/set_meta_data", $meta_data );
		return $this;
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
	protected function where( $query = [] ) {
		$this->query = array_merge( $query, $this->query );
		return $this;
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
	 * Make the API request.
	 *
	 * @param array  $args Array of arguments.
	 * @param string $endpoint Optional endpoint override.
	 *
	 * @return Model
	 */
	protected function makeRequest( $args = [], $endpoint = '' ) {
		return \SureCart::request( ...$this->prepareRequest( $args, $endpoint ) );
	}

	/**
	 * Prepare API Request Arguments.
	 *
	 * @param array  $args Array of arguments.
	 * @param string $endpoint Optional endpoint override.
	 *
	 * @return array $args for API request.
	 */
	protected function prepareRequest( $args, $endpoint = '' ) {
		// Create the endpoint.
		if ( ! $endpoint ) {
			$endpoint = ! empty( $args['id'] ) ? $this->endpoint . '/' . $args['id'] : $this->endpoint;
		}

		unset( $args['id'] );

		// add query vars.
		$args['query'] = $this->query;

		return [ $endpoint, $args, $this->cachable, $this->cache_key ];
	}

	/**
	 * Paginate results
	 *
	 * @param array $args Pagination args.
	 * @return mixed
	 */
	protected function paginate( $args = [] ) {
		$this->setPagination( $args );

		$items = $this->makeRequest();

		if ( $this->isError( $items ) ) {
			return $items;
		}

		if ( ! empty( $items->data ) ) {
			$models = [];
			foreach ( $items->data as $data ) {
				$models[] = new static( $data );
			}
			$items->data = $models;
		}

		return new Collection( $items );
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

		$this->query['limit'] = $args['per_page'];
		$this->query['page']  = $args['page'];

		return $this;
	}

	/**
	 * Fetch a list of items
	 *
	 * @return array|\WP_Error;
	 */
	protected function get() {
		$this->query['limit'] = $this->query['limit'] ?? 100;

		$items = $this->makeRequest();

		if ( $this->isError( $items ) ) {
			return $items;
		}

		// check empty.
		if ( empty( $items->data ) ) {
			return [];
		}

		$models = [];
		foreach ( $items->data as $data ) {
			$models[] = new static( $data );
		}

		return $models;
	}

	/**
	 * Get the first item in the query
	 */
	public function first() {
		$this->query['limit'] = 1;

		$items = $this->makeRequest();

		if ( $this->isError( $items ) ) {
			return $items;
		}

		$item = ! empty( $items->data[0] ) ? new static( $items->data[0] ) : null;

		return $item;
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

		$attributes = $this->makeRequest( [ 'id' => $id ] );

		if ( $this->isError( $attributes ) ) {
			return $attributes;
		}

		$this->fireModelEvent( 'found' );
		$this->syncOriginal();
		$this->fill( $attributes );

		return $this;
	}

	/**
	 * Is the response an Error?
	 *
	 * @param array|\WP_Error|\WP_REST_Response $response Response from request.
	 *
	 * @return boolean
	 */
	public function isError( $response ) {
		return is_wp_error( $response ) || ( $response instanceof \WP_REST_Response && ! in_array( $response->get_status(), [ 200, 201 ], true ) );
	}

	/**
	 * Get fresh instance from DB.
	 *
	 * @return self
	 */
	protected function fresh() {
		if ( ! $this->attributes['id'] ) {
			return $this;
		}

		return $this->makeRequest(
			[
				'id' => $this->attributes['id'],
			]
		);
	}

	/**
	 * Get fresh instance from DB.
	 *
	 * @return self
	 */
	protected function refresh() {
		if ( ! $this->attributes['id'] ) {
			return $this;
		}

		$attributes = $this->fresh();

		if ( $this->isError( $attributes ) ) {
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

		if ( $this->isError( $saved ) ) {
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

		// add created by WordPress param.
		$user_id = get_current_user_id();
		if ( $user_id && isset( $this->metadata ) ) {
			$this->metadata->wp_created_by = $user_id;
		}

		$created = $this->makeRequest(
			[
				'method' => 'POST',
				'body'   => [
					$this->object_name => $this->getAttributes(),
				],
			]
		);

		// bail if error.
		if ( $this->isError( $created ) ) {
			return $created;
		}

		// reset.
		$this->resetAttributes();

		// fill.
		$this->fill( $created ?? [] );

		// fire event.
		$this->fireModelEvent( 'created' );

		// clear account cache.
		if ( $this->cachable || $this->clears_account_cache ) {
			\SureCart::account()->clearCache();
		}

		return $this;
	}

	/**
	 * Queue a sync job for later.
	 *
	 * @return \SureCart\Background\QueueService
	 */
	protected function queueSync() {
		return \SureCart::queue()->async( 'surecart/sync/product', [ 'id' => $this->id ] );
	}

	/**
	 * Only return specific properties from the model.
	 *
	 * @param array $attributes Attributes to return.
	 *
	 * @return array
	 */
	protected function only( $attributes ) {
		$attributes = is_array( $attributes ) ? $attributes : func_get_args();
		return array_intersect_key( $this->toArray(), array_flip( $attributes ) );
	}

	/**
	 * Return all attributes except the ones passed.
	 *
	 * @param array $attributes Attributes to exclude.
	 */
	protected function without( $attributes ) {
		$attributes = is_array( $attributes ) ? $attributes : func_get_args();
		return array_diff_key( $this->toArray(), array_flip( $attributes ) );
	}

	/**
	 * Update the model.
	 *
	 * @param array $attributes Attributes to update.
	 * @return $this|\WP_Error|false
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

		$updated = $this->makeRequest(
			[
				'id'     => $this->id,
				'method' => 'PATCH',
				'body'   => [
					$this->object_name => $attributes,
				],
			]
		);

		if ( $this->isError( $updated ) ) {
			return $updated;
		}

		$this->resetAttributes();

		$this->fill( $updated );

		$this->fireModelEvent( 'updated' );

		// clear account cache.
		if ( $this->cachable || $this->clears_account_cache ) {
			\SureCart::account()->clearCache();
		}

		return $this;
	}

	/**
	 * Delete the model.
	 *
	 * @param string $id The id of the model to delete.
	 * @return $this|false
	 */
	protected function delete( $id = '' ) {
		$id = $id ? $id : $this->id;

		if ( $this->fireModelEvent( 'deleting' ) === false ) {
			return false;
		}

		$deleted = $this->makeRequest(
			[
				'id'     => $id,
				'method' => 'DELETE',
			]
		);

		if ( $this->isError( $deleted ) ) {
			return $deleted;
		}

		$this->fireModelEvent( 'deleted' );

		// clear account cache.
		if ( $this->cachable || $this->clears_account_cache ) {
			\SureCart::account()->clearCache();
		}

		return $deleted;
	}

	/**
	 * Set a model relation.
	 *
	 * @param string $attribute Attribute name.
	 * @param string $value     Value to set.
	 * @param string $model   Model name.
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
	 * @param string $attribute Attribute name.
	 * @return string|null;
	 */
	public function getRelationId( $attribute ) {
		$value = $this->attributes[ $attribute ] ?? null;
		return ! empty( $value['id'] ) ? $value['id'] : $value;
	}

	/**
	 * Set a model collection.
	 *
	 * @param string                      $attribute Attribute name.
	 * @param \SureCart\Models\Collection $collection Collection.
	 * @param string                      $model   Model name.
	 *
	 * @return void
	 */
	public function setCollection( $attribute, $collection, $model ) {
		$models = [];
		if ( ! empty( $collection->data ) && is_array( $collection->data ) ) {
			foreach ( $collection->data as $attributes ) {
				$models[] = is_a( $attributes, $model ) ? $attributes : new $model( $attributes );
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
		return json_decode( wp_json_encode( $this->attributes ), true );
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
	 * Get a in-memory cached attribute.
	 *
	 * @param string $key The attribute key.
	 * @return mixed|null The cached value or null if not found.
	 */
	protected function getCachedAttribute( $key ) {
		if ( ! isset( self::$attribute_cache ) ) {
			self::$attribute_cache = [];
		}

		if ( empty( $this->id ) ) {
			return null;
		}

		return self::$attribute_cache[ $this->id . '_' . $key ] ?? null;
	}

	/**
	 * Set a cached attribute in memory.
	 *
	 * @param string $key   The attribute key.
	 * @param mixed  $value The value to cache.
	 * @return void
	 */
	protected function setAttributeCache( $key, $value ) {
		if ( ! isset( self::$attribute_cache ) ) {
			self::$attribute_cache = [];
		}

		if ( empty( $this->id ) ) {
			return;
		}

		self::$attribute_cache[ $this->id . '_' . $key ] = $value;
	}

	/**
	 * Serialize to json.
	 *
	 * @return array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return $this->toArray();
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
				if ( is_a( $value, Objectable::class ) ) {
					$value = $value->toObject();
				}
			}
		);

		return $attributes;
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
			if ( ! method_exists( get_class( $this ), $method ) ) {
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
				if ( is_a( $value, Arrayable::class ) ) {
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
	public function offsetExists( $offset ): bool {
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
	public function offsetSet( $offset, $value ): void {
		$this->setAttribute( $offset, $value );
	}

	/**
	 * Unset the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return void
	 */
	public function offsetUnset( $offset ): void {
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
		return call_user_func_array( [ $this, $method ], $params );
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
		return call_user_func_array( [ new static(), $method ], $params );
	}
}
