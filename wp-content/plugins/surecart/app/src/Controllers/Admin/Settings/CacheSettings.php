<?php

namespace SureCart\Controllers\Admin\Settings;

/**
 * Controls the settings page.
 */
class CacheSettings {
	/**
	 * Show the page.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return function
	 */
	public function clear( \SureCartCore\Requests\RequestInterface $request ) {
		$url = wp_get_referer();
		delete_transient( 'surecart_account' );
		return \SureCart::redirect()->to( esc_url_raw( add_query_arg( 'status', 'cache_cleared', $url ) ) );
	}
}
