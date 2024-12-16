<?php
namespace SureCart\Request;

/**
 * Request caching service.
 */
class RequestCacheService {
	/**
	 * Has this been cached yet for the request?
	 *
	 * @var boolean
	 */
	protected static $cached = false;

	/**
	 * The endpoint for the request
	 *
	 * @var string
	 */
	protected $endpoint = '';

	/**
	 * The args for the request
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * The cache key on the account.
	 *
	 * @var string
	 */
	protected $account_cache_key = '';

	/**
	 * Needs an endpoint and args
	 *
	 * @param string $endpoint The endpoint for the request.
	 * @param array  $args The args for the request.
	 * @param string $account_cache_key The key on the account model to check for cache.
	 */
	public function __construct( $endpoint, $args, $account_cache_key ) {
		$this->endpoint          = $endpoint;
		$this->args              = $args;
		$this->account_cache_key = $account_cache_key;
	}

	/**
	 * Can we use transient caching.
	 *
	 * @return boolean
	 */
	public function canUseTransient() {
		$expand = $this->args['query']['expand'] ?? [];
		// if any expand has nested expansion, do not cache.
		foreach ( $expand as $item ) {
			if ( strpos( '.', $item ) !== false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the object cache key.
	 *
	 * @return string
	 */
	public function getObjectCacheKey() {
		return $this->endpoint . wp_json_encode( $this->args );
	}

	/**
	 * Get the transient cache key.
	 *
	 * @return string
	 */
	public function getTransientCacheKey() {
		$timestamp = \SureCart::account()->cache_keys->{$this->account_cache_key} ?? 0;
		if ( ! $timestamp ) {
			return false;
		}
		// we need to hash this this because there is a limit on string size for the key on the options table.
		return wp_hash( $this->endpoint . wp_json_encode( $this->args ) . $timestamp );
	}

	/**
	 * Set the cache.
	 *
	 * @param mixed  $data Data to set.
	 * @param string $type The type of cache to set.
	 *
	 * @return boolean
	 */
	public function setCache( $data, $type ) {
		switch ( $type ) {
			case 'object':
				return $this->setObjectCache( $data );
			case 'transient':
				return $this->setTransientCache( $data );
		}
		return false;
	}

	/**
	 * Set the object cache.
	 *
	 * @param mixed $data Data to set.
	 *
	 * @return boolean
	 */
	public function setObjectCache( $data ) {
		$object_cache_key = $this->getObjectCacheKey();
		// set in object cache.
		if ( $object_cache_key ) {
			return wp_cache_set( $object_cache_key, $data );
		}
		return false;
	}

	/**
	 * Get request from object cache.
	 *
	 * @return mixed
	 */
	public function getObjectCache() {
		// we cache this so we can request it several times.
		$object_cache_key = $this->getObjectCacheKey();

		// flush the cache on the first request to clear any redis caching.
		if ( ! self::$cached ) {
			wp_cache_flush();
			self::$cached = true;
		}

		// already made the request this cycle.
		return wp_cache_get( $object_cache_key );
	}

	/**
	 * Set the transient cache.
	 *
	 * @param mixed $data Data to set.
	 *
	 * @return boolean
	 */
	public function setTransientCache( $data ) {
		if ( ! $this->canUseTransient() ) {
			return false;
		}

		$transient_cache_key = $this->getTransientCacheKey();
		if ( $transient_cache_key ) {
			return set_transient( $transient_cache_key, $data, 60 * MINUTE_IN_SECONDS );
		}
		return false;
	}

	/**
	 * Get the transient cache.
	 *
	 * @return mixed
	 */
	public function getTransientCache() {
		if ( ! $this->canUseTransient() ) {
			return false;
		}
		return get_transient( $this->getTransientCacheKey() );
	}
}
