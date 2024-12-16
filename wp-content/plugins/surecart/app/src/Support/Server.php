<?php

namespace SureCart\Support;

/**
 * Handles server functions
 */
class Server {
	/**
	 * The url of the site.
	 *
	 * @return string
	 */
	protected $url = '';

	/**
	 * Get the url of the site
	 *
	 * @param string $url The url for the site.
	 */
	public function __construct( $url ) {
		$this->url = $url;
	}

	/**
	 * Are we on the localhost?
	 *
	 * @return boolean
	 */
	public function isLocalHost() {
		// check the ip address.
		if ( self::isLocalIP() ) {
			return true;
		}

		// check the domain for .local or .test.
		if ( self::isLocalDomain() ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the site is a local domain (.local or .test.)
	 *
	 * @return boolean
	 */
	public function isLocalDomain() {
		$parsed = explode( '.', wp_parse_url( $this->url, PHP_URL_HOST ) ?? '' );
		return in_array( end( $parsed ), array( 'local', 'test' ), true );
	}

	/**
	 * Is this a local IP address?
	 *
	 * @return boolean
	 */
	public function isLocalIP() {
		$ip_address = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
		return in_array( $ip_address, array( '127.0.0.1', '::1' ), true );
	}
}
