<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Subscription;

/**
 * If the model has an attached customer.
 */
trait SyncsCustomer {
	/**
	 * Should we sync the user to a customer?
	 *
	 * @return boolean
	 */
	protected function shouldSyncCustomer() {
		return get_option( 'surecart_auto_sync_user_to_customer', false );
	}
}
