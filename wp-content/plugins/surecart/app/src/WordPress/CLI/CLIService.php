<?php

namespace SureCart\WordPress\CLI;

use \WP_CLI;

/**
 * Our CLI service.
 */
class CLIService {
	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			return;
		}
		add_action( 'cli_init', [ $this, 'registerCLICommands' ] );
	}

	/**
	 * Registers CLI commands.
	 *
	 * @return void
	 */
	public function registerCLICommands() {
		$surecart = new CLICommands();
		WP_CLI::add_command( 'surecart', $surecart );
	}
}
