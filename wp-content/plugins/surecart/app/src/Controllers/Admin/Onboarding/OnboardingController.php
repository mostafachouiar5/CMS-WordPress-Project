<?php

namespace SureCart\Controllers\Admin\Onboarding;

use SureCart\Models\ApiToken;

/**
 * Handles onboarding http requests.
 */
class OnboardingController {
	/**
	 * Show the onboarding page.
	 *
	 * @return string
	 */
	public function show() {
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( OnboardingScriptsController::class, 'enqueue' ) );

		// return view.
		return '<div id="app"></div>';
	}

	/**
	 * Complete Step
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return function
	 */
	public function complete( \SureCartCore\Requests\RequestInterface $request ) {
		return \SureCart::view( 'admin/onboarding/complete' )->with( [ 'status' => $request->query( 'status' ) ] );
	}

	/**
	 * Save the API Token.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 * @return function
	 */
	public function save( \SureCartCore\Requests\RequestInterface $request ) {
		$url       = $request->getHeaderLine( 'Referer' );
		$api_token = $request->body( 'api_token' );

		if ( empty( $api_token ) ) {
			return \SureCart::redirect()->to( esc_url_raw( add_query_arg( 'status', 'missing', $url ) ) );
		}

		// get the saved token.
		$old_token = ApiToken::get();

		// save token.
		ApiToken::save( $api_token );

		// check if the token is valid.
		$account = \SureCart::account();

		if ( is_wp_error( $account ) ) {
			// save token.
			ApiToken::save( $old_token );
			wp_die( esc_html__( 'Invalid API Token', 'surecart' ) );
		}

		return \SureCart::redirect()->to( esc_url( admin_url( 'admin.php?page=sc-dashboard' ) ) );
	}
}
