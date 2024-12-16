<?php

namespace SureCart\Database;

/**
 * Table class for creating custom tables.
 */
class Table {
	/**
	 * Create a database table
	 *
	 * @param string  $name Table name.
	 * @param string  $columns Table columns.
	 * @param integer $version Table version.
	 * @param array   $opts Table options.
	 * @return void
	 */
	public function create( $name, $columns, $version = 1, $opts = [] ) {
		$current_version = (int) get_option( "{$name}_database_version", 0 );

		if ( $version === $current_version ) {
			return;
		}

		global $wpdb;

		$full_table_name = $wpdb->prefix . $name;

		$opts = wp_parse_args(
			$opts,
			[
				'table_options' => '',
			]
		);

		$charset_collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$charset_collate .= " COLLATE $wpdb->collate";
			}
		}

		$table_options = $charset_collate . ' ' . $opts['table_options'];

		// use dbDelta to create the table.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$created = dbDelta( "CREATE TABLE $full_table_name ( $columns ) $table_options" );
		update_option( "{$name}_database_version", $version );
		return $created;
	}

	/**
	 * Drops the table and database option
	 *
	 * @param string $name The name of the table to drop.
	 * @return boolean Whether the table was dropped.
	 */
	public function drop( $name ) {
		global $wpdb;
		$dropped = $wpdb->query( $wpdb->prepare( 'DROP TABLE IF EXISTS `%s`', $name ) );
		if ( true === $dropped ) {
			delete_option( "{$name}_database_version" );
		}
		return true === $dropped;
	}

	/**
	 * Does the database table exist?
	 *
	 * @param string $name Table name.
	 *
	 * @return boolean
	 */
	public function exists( $name ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $name;
		return $table_name === $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) ) );
	}
}
