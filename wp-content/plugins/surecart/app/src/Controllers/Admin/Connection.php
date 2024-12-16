<?php

namespace SureCart\Controllers\Admin;

use SureCart\Models\ApiToken;

class Connection {
	public function show( \SureCartCore\Requests\RequestInterface $request ) {
		return \SureCart::view( 'admin/connection' )->with(
			[
				'api_token' => ApiToken::get(),
				'status'    => $request->query( 'status' ),
			]
		);
	}

	public function save( \SureCartCore\Requests\RequestInterface $request, $view ) {
		$url       = $request->getHeaderLine( 'Referer' );
		$api_token = $request->body( 'api_token' );

		if ( empty( $api_token ) ) {
			return \SureCart::redirect()->to( esc_url_raw( add_query_arg( 'status', 'missing', $url ) ) );
		}

		// save token.
		ApiToken::save( $api_token );

		return \SureCart::redirect()->to( esc_url_raw( add_query_arg( 'status', 'saved', $url ) ) );
	}
}
