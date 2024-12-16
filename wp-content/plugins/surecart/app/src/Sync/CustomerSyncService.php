<?php


namespace SureCart\Sync;

use SureCart\Models\Customer;
use SureCart\Models\Purchase;
use SureCart\Models\User;

/**
 * Syncs customer records to WordPress users.
 */
class CustomerSyncService {
	/**
	 * Bootstrap any actions.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( 'surecart/sync/customers', [ $this, 'sync' ], 10, 4 );
		add_action( 'admin_notices', [ $this, 'showSyncNotice' ] );
	}

	/**
	 * Is this sync running.
	 *
	 * @return boolean
	 */
	public function isRunning() {
		return as_has_scheduled_action( 'surecart/sync/customer' ) || as_has_scheduled_action( 'surecart/sync/customers' );
	}

	/**
	 * Show an admin notice if customers are being synced.
	 *
	 * @return void
	 */
	public function showSyncNotice() {
		if ( ! $this->isRunning() ) {
			return;
		}

		echo wp_kses_post(
			\SureCart::notices()->render(
				[
					'type'  => 'info',
					'title' => esc_html__( 'SureCart customer sync in progress', 'surecart' ),
					'text'  => '<p>' . esc_html__( 'SureCart is syncing customers in the background. The process may take a little while, so please be patient.', 'surecart' ) . '</p>',
				]
			)
		);
	}

	/**
	 * Sync customers.
	 *
	 * @param string  $page Current page.
	 * @param integer $batch_size Batch size.
	 * @param boolean $create_user Create user.
	 * @param boolean $run_actions Run actions.
	 *
	 * @return void
	 */
	public function sync( $page, $batch_size, $create_user, $run_actions ) {
		// get customers.
		$customers = Customer::with( [ 'purchases' ] )->paginate(
			[
				'per_page' => $batch_size,
				'page'     => $page,
			]
		);

		// enqueue actions to sync an individual customer.
		foreach ( $customers->data as $customer ) {
			$this->syncCustomer( $customer, $create_user, $run_actions );
		}

		$total_pages = ceil( $customers->pagination->count / $customers->pagination->limit );
		// if the total number of pages less than or equal to the current page, we don't have another page.
		if ( $total_pages <= $customers->pagination->page ) {
			// we don't have another page.
			return;
		}

		// get the next batch.
		return as_enqueue_async_action(
			'surecart/sync/customers',
			[
				'page'        => $page + 1,
				'batch_size'  => $batch_size,
				'create_user' => $create_user,
				'run_actions' => $run_actions,
			],
			'surecart'
		);
	}

	/**
	 * Sync an individual customer.
	 *
	 * @param \SureCart\Models\Customer $customer Customer.
	 * @param boolean                   $create_user Create user.
	 * @param boolean                   $run_actions Run actions.
	 *
	 * @return \SureCart\Models\Customer|\WP_Error
	 */
	public function syncCustomer( $customer, $create_user, $run_actions ) {
		if ( ! $customer || is_wp_error( $customer ) ) {
			return $customer;
		}

		// Create or link a user.
		$user = $customer->getUser();
		if ( ! $user ) {
			$user = User::getUserBy( 'email', $customer->email );
			if ( $user ) {
				$user->setCustomerId( $customer->id, $customer->live_mode ? 'live' : 'test', true ); // force update.
			} elseif ( $create_user ) {
				$customer->createUser();
			}
		}

		// run purchase actions.
		if ( $run_actions ) {
			$unrevoked_purchases = array_filter(
				$customer->purchases->data ?? [],
				function ( $purchase ) {
					return ! $purchase->revoked;
				}
			);

			// A customer has more than the 20 purchases that are expanded, we need to fetch the rest.
			if ( ! empty( $customer->purchases->pagination->count ) && $customer->purchases->pagination->count > $customer->purchases->pagination->limit ) {
				// get 100 purchases.
				$unrevoked_purchases = Purchase::where(
					[
						'customer_id' => $customer->id,
						'revoked'     => false,
					]
				)->get();
			}

			foreach ( $unrevoked_purchases as $purchase ) {
				if ( $purchase->getWPUser() ) {
					do_action( 'surecart/purchase_invoked', $purchase );
				}
			}
		}

		return $customer;
	}
}
