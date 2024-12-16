<?php

namespace SureCart\Database\Tables;

use SureCart\Database\Table;

/**
 * The integrations table class.
 */
class IncomingWebhook {
	/**
	 * Holds the table instance.
	 *
	 * @var \SureCart\Database\Table
	 */
	protected $table;

	/**
	 * Version number for the table.
	 * Change this to update the table.
	 *
	 * @var integer
	 */
	protected $version = 1;

	/**
	 * Table name.
	 *
	 * @var string
	 */
	protected $name = 'surecart_incoming_webhooks';

	/**
	 * Get the table dependency.
	 *
	 * @param \SureCart\Database\Table $table The table dependency.
	 */
	public function __construct( Table $table ) {
		$this->table = $table;
	}

	/**
	 * Get the table name.
	 *
	 * @return string
	 */
	public function getName() {
		global $wpdb;
		return $wpdb->prefix . $this->name;
	}

	/**
	 * Add relationships custom table
	 * This allows for simple, efficient queries
	 *
	 * @return mixed
	 */
	public function install() {
		return $this->table->create(
			$this->name,
			'
            id bigint(20) unsigned NOT NULL auto_increment,
			webhook_id varchar(155) NOT NULL,
			data longtext NOT NULL,
			processed_at TIMESTAMP NULL,
			source varchar(155) NOT NULL DEFAULT "surecart",
			created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
			PRIMARY KEY  (id),
            KEY webhook_id (webhook_id),
            KEY processed_at (processed_at),
			KEY created_at (created_at),
            KEY updated_at (updated_at)
			',
			$this->version
		);
	}

	/**
	 * Uninstall tables
	 *
	 * @return boolean
	 */
	public function uninstall() {
		return $this->table->drop( $this->getName() );
	}

	/**
	 * Does the table exist?
	 *
	 * @return boolean
	 */
	public function exists() {
		return $this->table->exists( $this->name );
	}
}
