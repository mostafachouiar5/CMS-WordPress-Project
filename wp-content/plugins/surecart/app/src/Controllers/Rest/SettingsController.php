<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ApiToken;

/**
 * Handle price requests through the REST API
 */
class SettingsController {
	/**
	 * Index
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function find( \WP_REST_Request $request ) {
		return rest_ensure_response(
			[
				'object'                      => 'settings',
				'api_token'                   => ApiToken::get(),
				'uninstall'                   => (bool) get_option( 'sc_uninstall', false ),
				'stripe_payment_element'      => (bool) get_option( 'sc_stripe_payment_element', true ),
				'auto_sync_user_to_customer'  => (bool) get_option( 'surecart_auto_sync_user_to_customer', false ),
				'use_esm_loader'              => (bool) get_option( 'surecart_use_esm_loader', false ),
				'slide_out_cart_disabled'     => (bool) get_option( 'sc_slide_out_cart_disabled', false ),
				'load_block_assets_on_demand' => (bool) get_option( 'surecart_load_block_assets_on_demand', false ),
			]
		);
	}

	/**
	 * Update
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function edit( \WP_REST_Request $request ) {
		// save api token.
		if ( isset( $request['api_token'] ) ) {
			if ( ! empty( $request['api_token'] ) ) {
				$validate = $this->validate( $request->get_param( 'api_token' ) );
				if ( is_wp_error( $validate ) ) {
					return $validate;
				}
			}

			// Update the API token.
			ApiToken::save( $request['api_token'] );

			// Clear the account cache.
			\SureCart::account()->clearCache();
		}

		// update uninstall option.
		if ( isset( $request['uninstall'] ) ) {
			update_option( 'sc_uninstall', $request->get_param( 'uninstall' ) );
		}

		// update stripe payment_element option - used to enable the stripe's legacy card element.
		if ( isset( $request['stripe_payment_element'] ) ) {
			update_option( 'sc_stripe_payment_element', $request->get_param( 'stripe_payment_element' ) === false ? 0 : 1 );
		}

		// update performance option.
		if ( isset( $request['use_esm_loader'] ) ) {
			update_option( 'surecart_use_esm_loader', $request->get_param( 'use_esm_loader' ) );
		}

		// update slide out cart option.
		if ( isset( $request['slide_out_cart_disabled'] ) ) {
			update_option( 'sc_slide_out_cart_disabled', (bool) $request->get_param( 'slide_out_cart_disabled' ) );
		}

		if ( isset( $request['auto_sync_user_to_customer'] ) ) {
			update_option( 'surecart_auto_sync_user_to_customer', (bool) $request->get_param( 'auto_sync_user_to_customer' ) );
		}

		// update load block styles on demand option.
		if ( isset( $request['load_block_assets_on_demand'] ) ) {
			update_option( 'surecart_load_block_assets_on_demand', $request->get_param( 'load_block_assets_on_demand' ) );
		}

		return rest_ensure_response( $this->find( $request ) );
	}

	/**
	 * Validate the token.
	 *
	 * @param string $token The API token.
	 *
	 * @return true|\WP_Error
	 */
	protected function validate( $token = '' ) {
		$response = \SureCart::requests()->setToken( $token )->get( 'account' );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		return true;
	}
}
