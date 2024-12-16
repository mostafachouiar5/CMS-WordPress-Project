<?php

namespace SureCart\WordPress\CLI;

use WP_CLI;
use SureCart\Models\ProvisionalAccount;
/**
 * Our All CLI Commands class.
 */
class CLICommands {
	/**
	 * Seed Account
	 *
	 * @alias create-account
	 *
	 * @param Array $args Arguments in array format.
	 * @param Array $assoc_args Key value arguments stored in associated array format.
	 */
	public function seed( $args, $assoc_args ) {
		if ( empty( $assoc_args['email'] ) ) {
			WP_CLI::error( __( 'Email is required to seed an account.', 'surecart' ) );
		}
		$account = ProvisionalAccount::create(
			array(
				'email'  => $assoc_args['email'],
				'seed'   => ! empty( $assoc_args['seed'] ) ? (bool) $assoc_args['seed'] : false,
				'source' => ! empty( $assoc_args['source'] ) ? esc_html( $assoc_args['source'] ) : 'surecart_wp',
			)
		);
		if ( is_wp_error( $account ) ) {
			WP_CLI::error( $account->get_error_message() );
		}
		WP_CLI::success( __( 'Account seeded successfully.', 'surecart' ) );
	}
}
