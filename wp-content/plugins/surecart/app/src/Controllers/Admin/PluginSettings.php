<?php

namespace SureCart\Controllers\Admin;

use SureCart\Models\ApiToken;

/**
 * Handles the plugin settings page.
 */
class PluginSettings {
	/**
	 * Show the page.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return function
	 */
	public function show( \SureCartCore\Requests\RequestInterface $request ) {
		return \SureCart::view( 'admin/plugin' )->with(
			[
				'api_token'      => ApiToken::get(),
				'uninstall'      => get_option( 'sc_uninstall', false ),
				'use_esm_loader' => get_option( 'surecart_use_esm_loader', false ),
				'status'         => $request->query( 'status' ),
			]
		);
	}

	/**
	 * Save the page.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return function
	 */
	public function save( \SureCartCore\Requests\RequestInterface $request ) {
		$url       = $request->getHeaderLine( 'Referer' );
		$api_token = $request->body( 'api_token' );

		// update uninstall option.
		update_option( 'sc_uninstall', $request->body( 'uninstall' ) === 'on' );

		// update uninstall option.
		update_option( 'surecart_use_esm_loader', $request->body( 'use_esm_loader' ) === 'on' );

		// save token.
		ApiToken::save( $api_token );

		return \SureCart::redirect()->to( esc_url_raw( add_query_arg( 'status', 'saved', $url ) ) );
	}
}
