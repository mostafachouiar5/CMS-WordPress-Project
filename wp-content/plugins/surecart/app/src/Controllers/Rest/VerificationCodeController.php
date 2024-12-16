<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\User;
use SureCart\Models\VerificationCode;

/**
 * Handle verification code requests through the REST API
 */
class VerificationCodeController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = VerificationCode::class;

	/**
	 * Create model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function create( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		$user = $this->getUser( $request->get_param( 'login' ) );

		// bail if no user.
		if ( ! $user ) {
			return new \WP_Error( 'user_not_found', __( 'The user could not be found.', 'surecart' ) );
		}

		return $model->where( $request->get_query_params() )->create(
			[
				'email' => $user->user_email,
			]
		);
	}

	/**
	 * Verify a verification code
	 *
	 * @param \WP_REST_Request $request  Rest Request.
	 *
	 * @return \SureCart\Models\VerificationCode|\WP_Error
	 */
	public function verify( \WP_REST_Request $request ) {
		// run middleware.
		$model = $this->middleware( new $this->class(), $request );

		// bail if error.
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		$user = $this->getUser( $request->get_param( 'login' ) );
		if ( ! $user ) {
			return new \WP_Error(
				'invalid_email',
				__( 'There is no account with that username or email address.', 'surecart' )
			);
		}

		// verify the code.
		$verify = $model->where( $request->get_query_params() )->verify(
			[
				'email' => $user->user_email,
				'code'  => $request->get_param( 'code' ),
			]
		);

		// check for errors.
		if ( is_wp_error( $verify ) ) {
			return $verify;
		}

		// code is invalid or not verified.
		if ( empty( $verify->verified ) ) {
			return new \WP_Error( 'invalid_code', __( 'Invalid verification code', 'surecart' ) );
		}

		// get the user based on the login value.
		$user = $this->getUser( $request->get_param( 'login' ) );

		// bail if no user.
		if ( ! $user ) {
			return new \WP_Error( 'user_not_found', __( 'The user could not be found.', 'surecart' ) );
		}

		// login the user.
		$logged_in = $user->login();

		if ( is_wp_error( $logged_in ) ) {
			return $logged_in;
		}

		// return the model.
		return $verify;
	}

	/**
	 * Get the user from the login.
	 *
	 * @param string $login An email or login.
	 *
	 * @return \SureCart\Models\User|false
	 */
	public function getUser( $login ) {
		return User::getUserby( strpos( $login ?? '', '@' ) ? 'email' : 'login', $login );
	}
}
