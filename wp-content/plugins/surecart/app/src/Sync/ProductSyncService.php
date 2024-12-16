<?php


namespace SureCart\Sync;

use SureCart\Models\Product;

/**
 * This syncs an individual product to a post asynchronously.
 */
class ProductSyncService {
	/**
	 * The action name.
	 *
	 * @var string
	 */
	protected $action_name = 'surecart/sync/product';

	/**
	 * Application instance.
	 *
	 * @var \SureCart\Application
	 */
	protected $app = null;

	/**
	 * Whether to show a notice.
	 *
	 * @var boolean
	 */
	protected $with_notice = false;

	/**
	 * Constructor.
	 *
	 * @param \SureCart\Application $app The application.
	 */
	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * Bulk action service.
	 *
	 * @return \SureCart\Background\BulkActionService
	 */
	protected function bulkActionService() {
		return $this->app->resolve( 'surecart.bulk_action' );
	}

	/**
	 * Bootstrap any actions.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_action( $this->action_name, [ $this, 'handleScheduledSync' ], 10, 2 );
	}

	/**
	 * Whether to show a notice.
	 *
	 * @param boolean $with_notice Whether to show a notice.
	 *
	 * @return self
	 */
	public function withNotice( $with_notice = true ) {
		$this->with_notice = $with_notice;
		return $this;
	}

	/**
	 * Post sync service
	 *
	 * @return ProductsQueueProcess
	 */
	public function post() {
		return $this->app->resolve( 'surecart.process.product_post.sync' );
	}

	/**
	 * Queue the sync for a later time.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return \SureCart\Queue\Async
	 */
	public function queue( \SureCart\Models\Model $model ) {
		return \SureCart::queue()->async(
			$this->action_name,
			[
				'id'          => $model->id,
				'show_notice' => $this->with_notice,
			],
			'product-' . $model->id, // unique id for the product.
			true // force unique. This will replace any existing jobs.
		);
	}

	/**
	 * Check if the sync is scheduled.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return bool
	 */
	public function isScheduled( \SureCart\Models\Model $model ) {
		return \SureCart::queue()->isScheduled(
			$this->action_name,
			[
				'id'          => $model->id,
				'show_notice' => $this->with_notice,
			],
			'product-' . $model->id
		);
	}

	/**
	 * Check if there is a bulk action for the model.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return bool
	 */
	public function isBulkDeleting( $model ) {
		return $this->bulkActionService()->modelHasPendingAction( $model, 'delete_products' );
	}

	/**
	 * Cancel the sync for a later time.
	 *
	 * @param \SureCart\Models\Model $model The model.
	 *
	 * @return \SureCart\Queue\Async
	 */
	public function cancel( \SureCart\Models\Model $model ) {
		return \SureCart::queue()->cancel(
			$this->action_name,
			[
				'id'          => $model->id,
				'show_notice' => $this->with_notice,
			],
			'product-' . $model->id, // unique id for the product.
			true // force unique. This will replace any existing jobs.
		);
	}

	/**
	 * Run the model sync immediately.
	 *
	 * @param \SureCart\Models\Product $product The Product.
	 *
	 * @return \WP_Post|\WP_Error
	 */
	public function sync( \SureCart\Models\Product $product ) {
		return $this->post()->sync( $product );
	}

	/**
	 * Run the model sync immediately.
	 *
	 * @param string $id The product id.
	 *
	 * @return \WP_Post|\WP_Error|false|null
	 */
	public function delete( string $id ) {
		return $this->post()->delete( $id );
	}

	/**
	 * Fetch and sync product.
	 *
	 * @param string $id The product id to sync.
	 *
	 * @throws \Exception If there is an error.
	 *
	 * @return \WP_Post|\WP_Error
	 */
	public function handleScheduledSync( $id ) {
		// if the model is bulk deleting, return.
		if ( $this->isBulkDeleting( $id ) ) {
			return;
		}

		return Product::sync( $id );
	}
}
