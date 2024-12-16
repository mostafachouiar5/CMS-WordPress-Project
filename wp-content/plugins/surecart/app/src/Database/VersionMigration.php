<?php

namespace SureCart\Database;

/**
 * A migration that will run each time the version of the plugin changes.
 */
abstract class VersionMigration {
	/**
	 * The key for the migration.
	 *
	 * @var string
	 */
	protected $migration_key = 'surecart_migration_version';

	/**
	 * Run on init.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'admin_init', [ $this, 'maybeRun' ] );
	}

	/**
	 * Get the current version of the plugin.
	 *
	 * @return string
	 */
	public function currentVersion() {
		return \SureCart::plugin()->version();
	}

	/**
	 * Maybe let's run the migration.
	 *
	 * @return void
	 */
	public function maybeRun() {
		if ( ! $this->shouldMigrate() ) {
			return;
		}

		// run the migration.
		$this->run();

		// update the migration complete on admin_init complete, after all migrations have run.
		add_action( 'admin_init', [ $this, 'complete' ], 999999 );
	}

	/**
	 * Should we run this migration?
	 *
	 * @return boolean
	 */
	public function shouldMigrate(): bool {
		// check if we already have done this migration.
		return version_compare( $this->currentVersion(), $this->getLastMigrationVersion(), '!=' );
	}

	/**
	 * Run the migration
	 *
	 * @return void
	 */
	protected function run() {
	}

	/**
	 * Store the current plugin version when complete.
	 *
	 * @return void
	 */
	public function complete() {
		update_option( $this->migration_key, $this->currentVersion(), false ); // don't autoload since we are only doing this on the admin.
	}

	/**
	 * Get the last version there was a migration.
	 *
	 * @return string
	 */
	public function getLastMigrationVersion() {
		return get_option( $this->migration_key, '0.0.0' );
	}
}
