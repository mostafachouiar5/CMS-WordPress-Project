<?php

namespace SureCart\Database;

/**
 * Run this migration when version changes or for new installations.
 */
class RewriteRulesMigrationService extends VersionMigration {
	/**
	 * The key for the migration.
	 *
	 * @var string
	 */
	protected $migration_key = 'surecart_rewrites_migration_version';

	/**
	 * Run the migration.
	 *
	 * @return void
	 */
	public function run(): void {
		error_log( 'rewrite' );
		flush_rewrite_rules();
	}
}
