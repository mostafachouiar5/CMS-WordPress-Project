<?php

namespace SureCart\Database\Tables;

use SureCart\Database\Table;

/**
 * The integrations table class.
 */
class Integrations {

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
	protected $version = 2;

	/**
	 * Table name.
	 *
	 * @var string
	 */
	protected $name = 'surecart_integrations';

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
	public function getName(): string {
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
			model_name varchar(155) NULL,
			model_id varchar(155) NOT NULL,
			price_id varchar(155) NULL,
			variant_id varchar(155) NULL,
			integration_id varchar(155) NULL,
			provider varchar(155) NOT NULL,
			created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
			PRIMARY KEY  (id),
            KEY model_id (model_id),
            KEY integration_id (integration_id),
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
	public function uninstall(): bool {
		return $this->table->drop( $this->getName() );
	}

	/**
	 * Does the table exist?
	 *
	 * @return boolean
	 */
	public function exists(): bool {
		return $this->table->exists( $this->name );
	}
}
