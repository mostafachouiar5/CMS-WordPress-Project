<?php

namespace SureCart\BlockLibrary;

/**
 * Provide URL params related functionality.
 */
class URLParamService {
	/**
	 * Prefix.
	 *
	 * @var string
	 */
	protected $prefix = 'query';

	/**
	 * Pagination Key.
	 *
	 * @var string
	 */
	protected $pagination_key = 'page';

	/**
	 * Search Key.
	 *
	 * @var string
	 */
	protected $search_key = 'search';

	/**
	 * Unique instance ID.
	 *
	 * @var string
	 */
	protected $instance_id = '';

	/**
	 * URL.
	 *
	 * @var string|false
	 */
	protected $url = false;

	/**
	 * Set the prefix.
	 *
	 * @param string $prefix Prefix.
	 */
	public function __construct( $prefix = 'query' ) {
		global $sc_query_id;
		$this->prefix      = $prefix;
		$this->instance_id = $sc_query_id;
	}

	/**
	 * Set the block ID.
	 *
	 * @param string $prefix Prefix.
	 */
	public function setPrefix( $prefix ) {
		$this->prefix = $prefix;
		return $this;
	}

	/**
	 * Set the block ID.
	 *
	 * @param string $instance_id Unique instance ID.
	 */
	public function setInstanceId( $instance_id ) {
		$this->instance_id = $instance_id;
		return $this;
	}

	/**
	 * Get a unique key for a block.
	 *
	 * @param  string $name Name.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return string
	 */
	public function getKey( $name = '', $instance_id = '' ) {
		$instance_id = $instance_id ? $instance_id : $this->instance_id;
		$prefix      = ! empty( $this->prefix ) ? ( $this->prefix . '-' ) : '';
		if ( ! $instance_id ) {
			return trim( $prefix . strtolower( $name ), '-' );
		}
		return trim( $prefix . $instance_id . '-' . strtolower( $name ), '-' );
	}

	/**
	 * Get the name of a key.
	 *
	 * @param  string $key Key.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return string
	 */
	public function getName( $key = '', $instance_id = '' ) {
		$instance_id = $instance_id ? $instance_id : $this->instance_id;
		$prefix      = ! empty( $this->prefix ) ? ( $this->prefix . '-' ) : '';

		// Strip the prefix if it exists.
		if ( ! empty( $prefix ) && strpos( $key, $prefix ) === 0 ) {
			$key = substr( $key, strlen( $prefix ) );
		}

		// Strip the instance ID if it exists.
		if ( ! empty( $instance_id ) && strpos( $key, $instance_id . '-' ) === 0 ) {
			$key = substr( $key, strlen( $instance_id . '-' ) );
		}

		// Return the original name.
		return $key;
	}

	/**
	 * Get the filter arguments.
	 *
	 * @param  string $name Name.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return array
	 */
	public function getArg( $name, $instance_id = '' ) {
		$instance_id = $instance_id ? $instance_id : $this->instance_id;
		$key         = $this->getKey( $name, $instance_id );
		return $_GET[ $key ] ?? null;
	}

	/**
	 * Get the filter arguments.
	 *
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return array
	 */
	public function getArgs( $instance_id = '' ) {
		$instance_id = $instance_id ? $instance_id : $this->instance_id;
		$args        = [];
		foreach ( $_GET as $key => $value ) {
			if ( strpos( $key, $this->getKey( '', $instance_id ) ) === 0 ) {
				$args[ $key ] = $value;
			}
		}
		return $args;
	}

	/**
	 * Get the filter arguments.
	 *
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return array
	 */
	public function getAllTaxonomyArgs( $instance_id = '' ) {
		$instance_id   = $instance_id ? $instance_id : $this->instance_id;
		$args          = $this->getArgs( $instance_id ); // Use getArgs to get filtered arguments.
		$taxonomy_args = [];

		foreach ( $args as $key => $value ) {
			$taxonomy_name = $this->getName( $key, $instance_id );
			if ( taxonomy_exists( $taxonomy_name ) ) {
				$taxonomy_args[ $taxonomy_name ] = $value;
			}
		}

		return $taxonomy_args;
	}

	/**
	 * Get the current page.
	 *
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return int
	 */
	public function getCurrentPage( $instance_id = '' ) {
		$instance_id = $instance_id ? $instance_id : $this->instance_id;
		$key         = $this->getKey( $this->pagination_key, $instance_id );
		return max( 1, absint( $_GET[ $key ] ?? 1 ) );
	}

	/**
	 * Add a generic argument to the URL.
	 *
	 * @param  string       $key Key.
	 * @param  string|array $value Value.
	 * @param  string       $instance_id Unique instance ID.
	 * @return string
	 */
	public function addArg( $key, $value, $instance_id = '' ) {
		// get the instance ID.
		$instance_id = $instance_id ? $instance_id : $this->instance_id;
		// get the key for this filter argument.
		$key = $this->getKey( $key, $instance_id );
		// make sure the value is always lowercase.
		$value = is_array( $value ) ? array_map( 'strtolower', $value ) : strtolower( $value );
		// return the new URL without pagination for filtering.
		$this->url = add_query_arg( strtolower( $key ), $value, $this->url );
		// return this.
		return $this;
	}

	/**
	 * Get the URL.
	 *
	 * @return string
	 */
	public function url() {
		return $this->url;
	}

	/**
	 * Add a pagination argument to the URL.
	 *
	 * @param  int    $page Page.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return string
	 */
	public function addPageArg( $page, $instance_id = '' ) {
		return $this->addArg( $this->pagination_key, $page, $instance_id );
	}

	/**
	 * Add a filter argument to the URL.
	 *
	 * @param  string $key Key.
	 * @param  string $value Value.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return string
	 */
	public function addFilterArg( $key, $value, $instance_id = '' ) {
		// get the instance ID.
		$instance_id = $instance_id ? $instance_id : $this->instance_id;

		// get the key for this filter argument.
		$key = $this->getKey( $key, $instance_id );

		// get the existing filters.
		$existing_filters = $_GET[ $key ] ?? [];

		// add the new filter.
		$filters = array_unique( array_merge( $existing_filters, [ $value ] ) );

		// return the new URL without pagination for filtering.
		return remove_query_arg(
			[
				$this->getKey( $this->pagination_key, $instance_id ),
				$this->getKey( $this->search_key, $instance_id ),
			],
			add_query_arg( $key, $filters, $this->url )
		);
	}

	/**
	 * Check if a filter argument exists in the URL.
	 *
	 * @param  string $key Key.
	 * @param  string $value Value.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return bool
	 */
	public function hasFilterArg( $key, $value, $instance_id = '' ) {
		// get the instance ID.
		$instance_id = $instance_id ? $instance_id : $this->instance_id;

		// get the key for this filter argument.
		$key = $this->getKey( $key, $instance_id );

		// get the existing filters.
		$existing_filters = $_GET[ $key ] ?? [];

		// check if the value exists in the existing filters.
		return in_array( strval( $value ), $existing_filters, false );
	}

	/**
	 * Remove a filter argument from the URL.
	 *
	 * @param  string $key Key.
	 * @param  string $value Value.
	 * @param  string $instance_id Unique instance ID.
	 *
	 * @return string
	 */
	public function removeFilterArg( $key, $value, $instance_id = '' ) {
		// get the instance ID.
		$instance_id = $instance_id ? $instance_id : $this->instance_id;

		// get the key for this filter argument.
		$key = $this->getKey( $key, $instance_id );

		// get the existing filters.
		$existing_filters = $_GET[ $key ] ?? [];

		// remove the new filter.
		$filters = array_diff( $existing_filters, [ $value ] );

		// return the new URL without pagination for filtering.
		return remove_query_arg(
			[
				$this->getKey( $this->pagination_key, $instance_id ),
				$this->getKey( $this->search_key, $instance_id ),
			],
			add_query_arg( $key, $filters, $this->url )
		);
	}
}
