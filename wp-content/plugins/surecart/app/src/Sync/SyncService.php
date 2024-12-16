<?php
namespace SureCart\Sync;

use SureCart\Background\Migration\ProductsSyncProcess;
use SureCart\Sync\CustomerSyncService;
use SureCart\Sync\ProductSyncService;

/**
 * The sync service.
 */
class SyncService {
	/**
	 * Application instance.
	 *
	 * @var \SureCart\Application
	 */
	protected $app = null;

	/**
	 * Constructor.
	 *
	 * @param \SureCart\Application $app The application.
	 */
	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * Get the (multiple) products sync process.
	 *
	 * @return ProductsSyncProcess
	 */
	public function products() {
		return $this->app->resolve( 'surecart.sync.products' );
	}

	/**
	 * Get the (single) product sync service.
	 *
	 * @return ProductSyncService
	 */
	public function product() {
		return $this->app->resolve( 'surecart.sync.product' );
	}

	/**
	 * Get the (single) product sync service.
	 *
	 * @return ProductSyncService
	 */
	public function collection() {
		return $this->app->resolve( 'surecart.sync.collection' );
	}

	/**
	 * Get the customer sync service.
	 *
	 * @return CustomerSyncService
	 */
	public function customers() {
		return $this->app->resolve( 'surecart.sync.customers' );
	}

	/**
	 * Get the store sync service.
	 *
	 * @return StoreSyncService
	 */
	public function store() {
		return $this->app->resolve( 'surecart.sync.store' );
	}
}
