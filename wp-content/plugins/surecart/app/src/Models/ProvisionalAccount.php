<?php

namespace SureCart\Models;

/**
 * Provisional Account model
 */
class ProvisionalAccount extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'public/provisional_accounts';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'provisional_account';

	/**
	 * Make the API request.
	 *
	 * @param array  $args Array of arguments.
	 * @param string $endpoint Optional endpoint override.
	 *
	 * @return Model
	 */
	protected function makeRequest( $args = [], $endpoint = '' ) {
		return \SureCart::unAuthorizedRequest( ...$this->prepareRequest( $args, $endpoint ) );
	}

	/**
	 * Create a new model
	 *
	 * @param array $attributes Attributes to create.
	 *
	 * @return $this|false
	 */
	protected function create( $attributes = [] ) {
		// we only allow this if the setup is not complete.
		if ( ! empty( ApiToken::get() ) ) {
			$testing = defined( 'SC_E2E_TESTING' ) ? (bool) SC_E2E_TESTING : false;
			if ( ! $testing ) {
				return new \WP_Error( 'setup_complete', __( 'You have already set up your store.', 'surecart' ) );
			}
		}

		// set account name as the site name if nothing is provided.
		if ( empty( $attributes['account_name'] ) ) {
			$attributes['account_name'] = get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : get_bloginfo( 'url' );
		}

		// set the account url from the blog url.
		if ( empty( $attributes['account_url'] ) ) {
			$attributes['account_url'] = get_bloginfo( 'url' );
		}

		// set source with fallback to the option.
		$attributes['source'] = isset( $attributes['source'] ) ? sanitize_text_field( wp_unslash( $attributes['source'] ) ) : sanitize_text_field( get_option( 'surecart_source', 'surecart_wp' ) );

		return parent::create( $attributes );
	}
}
