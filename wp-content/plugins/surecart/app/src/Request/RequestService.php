<?php

namespace SureCart\Request;

use SureCart\Models\ApiToken;
use SureCart\Support\Errors\ErrorsService;

/**
 * Provide api request functionality.
 */
class RequestService {
	/**
	 * Has this been cached yet for the request?
	 *
	 * @var boolean
	 */
	protected static $cached = false;

	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	protected $token = '';

	/**
	 * The base path for the request.
	 *
	 * @var string
	 */
	protected $base_path;

	/**
	 * Errors service container
	 *
	 * @var \SureCart\Support\Errors\ErrorsService;
	 */
	protected $errors_service;

	/**
	 * What type of cached request is this.
	 *
	 * @var string|null
	 */
	protected $cache_status = 'none';

	/**
	 * Is this request authorized?
	 *
	 * @var boolean
	 */
	protected $authorized = true;

	/**
	 * Number of retries.
	 *
	 * @var integer
	 */
	protected $current_retries = 0;

	/**
	 * Total number of retries.
	 *
	 * @var integer
	 */
	protected $total_retries = 1;

	/**
	 * Status codes to retry.
	 *
	 * @var array
	 */
	protected $retry_status_codes = [ 409 ];

	/**
	 * Constructor.
	 *
	 * @param string                                 $token The rest api base path.
	 * @param string                                 $base_path The rest api base path.
	 * @param \SureCart\Support\Errors\ErrorsService $errors_service The error handling service.
	 * @param boolean                                $authorized Is this request authorized.
	 *
	 * @return void
	 */
	public function __construct( $token = '', $base_path = '/v1', $errors_service = null, $authorized = true ) {
		// error handing service.
		$this->errors_service = $errors_service ? $errors_service : new ErrorsService();
		// set the token.
		$this->token = $token;
		// set the base path and url.
		$this->base_path  = $base_path;
		$this->authorized = $authorized;
	}

	/**
	 * Set the API token on the fly.
	 *
	 * @param string $token API token.
	 *
	 * @return $this
	 */
	public function setToken( $token ) {
		$this->token = $token;
		return $this;
	}

	/**
	 * Get the base url.
	 */
	public function getBaseUrl() {
		return untrailingslashit( SURECART_API_URL ) . trailingslashit( $this->base_path );
	}

	/**
	 * Should we get a cached request?
	 *
	 * @return boolean
	 */
	public function shouldFindCache( $cachable, $cache_key, $args = [] ) {
		// only for fetch requests.
		if ( isset( $args['method'] ) && 'GET' !== $args['method'] ) {
			return false;
		}

		// if the args are set, then do what they say.
		if ( isset( $args['query']['cached'] ) ) {
			return (bool) $args['query']['cached'];
		}

		// don't cache edit context.
		if ( isset( $args['query']['context'] ) && 'edit' === $args['query']['context'] ) {
			return false;
		}

		return (bool) $cachable && $cache_key;
	}

	/**
	 * Respond to the request.
	 *
	 * @param array  $response Reponse data.
	 * @param array  $args    Request arguments.
	 * @param string $endpoint The endpoint to request.
	 *
	 * @return array Response data.
	 */
	public function respond( $response, $args, $endpoint ) {
		if ( is_array( $response ) ) {
			foreach ( $response as $item ) {
				$item->cache_status = $this->cache_status;
			}
		}

		if ( is_object( $response ) ) {
			$response->cache_status = $this->cache_status;
		}

		return apply_filters( 'surecart/request/response', $response, $args, $endpoint );
	}

	/**
	 * Set the response cache status.
	 *
	 * @param object $response Response object.
	 * @param string $status The response status.
	 *
	 * @return void
	 */
	public function setResponseCacheStatus( $response, $status ) {
		if ( is_array( $response ) ) {
			foreach ( $response as $item ) {
				$item->cached = $status;
			}
		} elseif ( is_object( $response ) ) {
			$response->cached = $status;
		}

		return $response;
	}

	/**
	 * Make the request
	 *
	 * @param string  $endpoint Endpoint to request.
	 * @param array   $args Arguments for request.
	 * @param boolean $cachable Should this request be cached.
	 * @param string  $cache_key The cache key to use.
	 *
	 * @return mixed
	 */
	public function makeRequest( $endpoint, $args = [], $cachable = false, $cache_key = '' ) {
		// use the cache service for this request.
		$cache = new RequestCacheService( $endpoint, $args, $cache_key );

		// check if we should get a cached version of this.
		if ( $this->shouldFindCache( $cachable, $cache_key, $args ) ) {
			// get from cache.
			$response_body = $cache->getTransientCache();
			// we have a cached response.
			if ( false !== $response_body ) {
				$this->cache_status = 'transient';
				return $this->respond( $response_body, $args, $endpoint );
			}
		}

		// make the uncached request.
		$response_body = $this->makeUncachedRequest( $endpoint, $args );

		if ( is_wp_error( $response_body ) ) {
			return $response_body;
		}

		// set in object cache.
		$cache->setCache( $response_body, 'object' );
		if ( (bool) $cachable && $cache_key ) {
			$cache->setCache( $response_body, 'transient' );
		}

		// return response.
		return $this->respond( $response_body, $args, $endpoint );
	}

	/**
	 * Make the uncached request.
	 *
	 * @param string $endpoint Endpoint to request.
	 * @param array  $args Arguments for request.
	 *
	 * @return mixed
	 */
	public function makeUncachedRequest( $endpoint, $args = [] ) {
		// must have a token for the request.
		if ( $this->authorized && empty( $this->token ) ) {
			return new \WP_Error( 'missing_token', __( 'Please connect your site to SureCart.', 'surecart' ) );
		}

		// make sure we send json.
		if ( empty( $args['headers']['Content-Type'] ) ) {
			$args['headers']['Content-Type'] = 'application/json';
		}

		// add auth.
		if ( $this->authorized && ! empty( $this->token ) && empty( $args['headers']['Authorization'] ) ) {
			$args['headers']['Authorization'] = "Bearer $this->token";
		}

		// add version header.
		$args['headers']['X-SURECART-WP-PLUGIN-VERSION'] = \SureCart::plugin()->version();

		// add referer header.
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$args['headers']['X-SURECART-REFERRER'] = esc_url_raw( $_SERVER['HTTP_REFERER'] );
		}

		// parse args.
		$args = wp_parse_args(
			$args,
			[
				'timeout'   => 20,
				'sslverify' => true,
			]
		);

		// filter args and endpoint.
		$args     = apply_filters( 'surecart/request/args', $args, $endpoint );
		$endpoint = apply_filters( 'surecart/request/endpoint', $endpoint, $args );

		// make url.
		$url = trailingslashit( $this->getBaseUrl() ) . untrailingslashit( $endpoint );

		// add query args.
		if ( ! empty( $args['query'] ) ) {
			$url = add_query_arg( $this->parseArgs( $args['query'] ), $url );
			$url = preg_replace( '/%5B[0-9]+%5D/', '%5B%5D', $url );
			unset( $args['query'] );
		}

		// json encode body.
		if ( ! empty( $args['body'] ) ) {
			if ( 'application/json' === $args['headers']['Content-Type'] ) {
				$args['body'] = wp_json_encode( $this->parseArgs( $args['body'] ) );
			}
		}

		// make request.
		$response = $this->remoteRequest( $url, $args );

		// bail early if it's a wp_error.
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		// handle handle retries.
		if ( in_array( $response_code, $this->retry_status_codes ) ) {
			$this->current_retries++;
			if ( $this->current_retries <= $this->total_retries ) {
				call_user_func_array( [ $this, __METHOD__ ], func_get_args() );
			}
		}

		$response_body = wp_remote_retrieve_body( $response );
		$admin_notice  = (array) wp_remote_retrieve_header( $response, 'X-SURECART-WP-ADMIN-NOTICE' );

		if ( ! $this->authorized ) {
			$api_token = (string) wp_remote_retrieve_header( $response, 'X-SURECART-API-TOKEN' );
			ApiToken::save( $api_token );
		}

		if ( $admin_notice ) {
			// we don't care if this fails.
			try {
				\SureCart::notices()->showResponseNotice( $admin_notice );
			} catch ( \Exception $e ) {
				error_log( $e->getMessage() );
			}
		}

		// Handle invalid token first.
		if ( $this->authorized && 401 === $response_code ) {
			ApiToken::clear();
			return new \WP_Error( 'invalid_token', __( 'Invalid API token.', 'surecart' ) );
		}

		// check for errors.
		if ( ! in_array( $response_code, [ 200, 201 ], true ) ) {
			$body = json_decode( $response_body, true );
			if ( is_string( $body ) ) {
				return new \WP_Error( 'error', $response_body );
			}
			return $this->errors_service->translate( $body, $response_code );
		}

		return json_decode( $response_body );
	}

	/**
	 * Make the remote request.
	 *
	 * @param string $url The url to request.
	 * @param array  $args The args to pass to the request.
	 *
	 * @return mixed
	 */
	public function remoteRequest( $url, $args = [] ) {
		return wp_remote_request( esc_url_raw( $url ), $args );
	}

	/**
	 * Make a get request
	 *
	 * @param string $endpoint Endpoint for the request.
	 * @param array  $args Request arguments.
	 *
	 * @return mixed
	 */
	public function get( $endpoint, $args = [] ) {
		$args['method'] = 'GET';
		return $this->makeRequest( $endpoint, $args );
	}

	/**
	 * Make a post request
	 *
	 * @param string $endpoint Endpoint for the request.
	 * @param array  $args Request arguments.
	 *
	 * @return mixed
	 */
	public function post( $endpoint, $args = [] ) {
		$args['method'] = 'POST';
		return $this->makeRequest( $endpoint, $args );
	}

	/**
	 * Make a put request
	 *
	 * @param string $endpoint Endpoint for the request.
	 * @param array  $args Request arguments.
	 *
	 * @return mixed
	 */
	public function put( $endpoint, $args = [] ) {
		$args['method'] = 'PUT';
		return $this->makeRequest( $endpoint, $args );
	}

	/**
	 * Make a patch request
	 *
	 * @param string $endpoint Endpoint for the request.
	 * @param array  $args Request arguments.
	 *
	 * @return mixed
	 */
	public function patch( $endpoint, $args = [] ) {
		$args['method'] = 'PATCH';
		return $this->makeRequest( $endpoint, $args );
	}

	/**
	 * Make a delete request
	 *
	 * @param string $endpoint Endpoint for the request.
	 * @param array  $args Request arguments.
	 *
	 * @return mixed
	 */
	public function delete( $endpoint, $args = [] ) {
		$args['method'] = 'DELETE';
		return $this->makeRequest( $endpoint, $args );
	}

	/**
	 * Removes empty args
	 *
	 * @param array $args Array of arguments.
	 */
	protected function parseArgs( $args = [] ) {
		if ( ! is_array( $args ) ) {
			return $args;
		}
		foreach ( $args as $key => $arg ) {
			// unset null.
			if ( null === $arg ) {
				unset( $args[ $key ] );
			}

			// filter out wp params.
			if ( in_array( $key, [ 'locale', 'rest_route' ], true ) ) {
				unset( $args[ $key ] );
			}

			// convert bool to int to prevent getting unset.
			if ( is_bool( $arg ) ) {
				$args[ $key ] = $arg ? 1 : 0;
			}

			// url encode any strings.
			if ( is_string( $arg ) ) {
				$args[ $key ] = urlencode( $arg );
			}
		}

		return $args;
	}
}
