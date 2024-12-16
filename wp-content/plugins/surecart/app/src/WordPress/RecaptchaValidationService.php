<?php

namespace SureCart\WordPress;

/**
 * Recaptcha Validation Service.
 */
class RecaptchaValidationService {
	/**
	 * Is recaptcha Enabled?
	 *
	 * @return boolean
	 */
	public function isEnabled() {
		return (bool) get_option( 'surecart_recaptcha_enabled', false );
	}

	/**
	 * Get reCaptcha min score.
	 *
	 * @return string
	 */
	public function getMinScore() {
		return apply_filters( 'surecart_recaptcha_min_score', 0.5 );
	}

	/**
	 * Get reCaptcha secret key.
	 *
	 * @return string
	 */
	public function getSecretKey() {
		return get_option( 'surecart_recaptcha_secret_key', '' );
	}

	/**
	 * Get reCaptcha secret key.
	 *
	 * @return string
	 */
	public function getSiteKey() {
		return get_option( 'surecart_recaptcha_site_key', '' );
	}

	/**
	 * Get reCaptcha response data.
	 *
	 * @param string $grecaptcha recaptcha token.
	 * @return object
	 */
	public function makeRequest( $grecaptcha ) {
		$recaptcha_verify = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			[
				'method' => 'POST',
				'body'   => [
					'secret'   => $this->getSecretKey(),
					'response' => $grecaptcha,
				],
			]
		);
		return json_decode( wp_remote_retrieve_body( $recaptcha_verify ) );
	}

	/**
	 * Check is validate token.
	 *
	 * @param object $verify_data recaptcha token.
	 * @return bool
	 */
	public function isTokenValid( $verify_data ) {
		if ( empty( $verify_data->success ) ) {
			return false;
		}
		return (bool) $verify_data->success;
	}

	/**
	 * Check is validate score.
	 *
	 * @param object $verify_data recaptcha token.
	 * @return bool
	 */
	public function isValidScore( $verify_data ) {
		return $verify_data->score && $verify_data->score >= $this->getMinScore();
	}

	/**
	 * Validate the recaptcha.
	 *
	 * @param string $grecaptcha_token The recaptcha token
	 *
	 * @return true|\WP_Error
	 */
	public function validate( $grecaptcha_token ) {
		$response = $this->makeRequest( $grecaptcha_token );

		// recaptcha failed.
		if ( ! $this->isTokenValid( $response ) ) {
			return new \WP_Error( 'invalid_recaptcha', __( 'Invalid recaptcha check. Please try again.', 'surecart' ) );
		}

		// score is not valid.
		if ( apply_filters( 'surecart_recaptcha_needed_validation_score', false ) && ! $this->isValidScore( $response ) ) {
			return new \WP_Error( 'invalid_recaptcha_score', __( 'Invalid recaptcha score. Please try again.', 'surecart' ) );
		}

		return true;
	}
}
