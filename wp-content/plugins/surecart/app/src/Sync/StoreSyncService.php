<?php
namespace SureCart\Sync;

/**
 * The store sync service.
 *
 * This service is responsible for syncing the store
 * data when the account id is first set or changed.
 *
 * @since 3.0.0
 * @package SureCart\Sync
 */
class StoreSyncService {
	/**
	 * The option name for the stored account.
	 *
	 * @var string
	 */
	protected $option_name = 'surecart_current_account_id';

	/**
	 * Bootstrap the service.
	 *
	 * @return mixed
	 */
	public function bootstrap() {
		add_action( 'admin_init', array( $this, 'maybeStartSync' ) );
	}

	/**
	 * Retrieves the stored account from the WordPress options.
	 *
	 * @return string The stored account.
	 */
	public function getStoredAccount() {
		return get_option( $this->option_name, null );
	}

	/**
	 * Retrieves the current plugin account.
	 *
	 * @return string The current plugin account.
	 */
	public function currentAccountId() {
		return \SureCart::account()->id ?? '';
	}

	/**
	 * Flush the rewrite rules on account change.
	 *
	 * @return boolean
	 */
	public function maybeStartSync() {
		$current_account_id = $this->currentAccountId();
		$stored_account_id  = $this->getStoredAccount();

		// there is no current account id, or the stored account id is the same as the current account id.
		if ( empty( $current_account_id ) || $current_account_id === $stored_account_id ) {
			return false;
		}

		return $this->startSync();
	}

	/**
	 * Flushes the rewrite rules and updates the stored account.
	 *
	 * @return boolean
	 */
	public function startSync() {
		$this->sync();
		return update_option( $this->option_name, $this->currentAccountId(), false );
	}

	/**
	 * Sync the store data.
	 *
	 * @return mixed
	 */
	public function sync() {
		if ( \SureCart::sync()->products()->isActive() ) {
			return false;
		}
		return \SureCart::sync()->products()->dispatch();
	}
}
