<?php

namespace SureCart\Background;

use SureCart\Models\IncomingWebhook;

/**
 * SureCart Queue
 *
 * A job queue using WordPress actions.
 */
class AsyncWebhookService extends AsyncRequest {
	/**
	 * Map object names to their models.
	 *
	 * @var array
	 */
	protected $models = [
		'charge'           => \SureCart\Models\Charge::class,
		'coupon'           => \SureCart\Models\Coupon::class,
		'customer'         => \SureCart\Models\Customer::class,
		'purchase'         => \SureCart\Models\Purchase::class,
		'price'            => \SureCart\Models\Price::class,
		'product'          => \SureCart\Models\Product::class,
		'period'           => \SureCart\Models\Period::class,
		'order'            => \SureCart\Models\Order::class,
		'refund'           => \SureCart\Models\Refund::class,
		'subscription'     => \SureCart\Models\Subscription::class,
		'invoice'          => \SureCart\Models\Invoice::class,
		'account'          => \SureCart\Models\Account::class,
		'webhook_endpoint' => \SureCart\Models\Webhook::class,
	];

	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap() {
		// nothing to bootstrap.
	}

	/**
	 * Enqueue an action to run one time, as soon as possible
	 *
	 * @var string
	 */
	protected $prefix = 'surecart';

	/**
	 * Action for ajax hooks.
	 *
	 * @var string
	 */
	protected $action = 'async_webhook';

	/**
	 * Handle a dispatched request.
	 *
	 * @param integer $id The webhook process id.
	 * @return void
	 * @throws \Exception If no id is specified.
	 */
	public function handle( $id = 0 ) {
		// get the webhook.
		$id = (int) ( $id ? $id : $_POST['id'] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

		// get the event name.
		if ( empty( $id ) ) {
			error_log( 'No id specified for webhook' );
			throw new \Exception( 'No id specified for webhook' );
		}

		// find the webhook.
		$webhook = IncomingWebhook::find( $id );

		// get WP error and throw exception.
		if ( is_wp_error( $webhook ) ) {
			error_log( 'SureCart Webhook Processing Error (' . esc_html( $id ) . ') ' . $webhook->get_error_message() );
			throw new \Exception( $webhook->get_error_message() );
		}

		// get the event name.
		if ( empty( $webhook->data->type ) ) {
			error_log( 'No event specified for webhook' );
			throw new \Exception( 'No event specified for webhook' );
		}

		$object_name = $webhook->data->data->object->object ?? '';

		// get model.
		$class = $this->models[ $object_name ] ?? null;

		// We don't have a model. That's okay since we only subscribe to specific items.
		if ( empty( $class ) ) {
			$webhook->update( [ 'processed_at' => current_time( 'mysql' ) ] );
			return;
		}

		// do the action.
		do_action( $this->createEventName( $webhook->data->type ), new $class( $webhook->data->data->object ), $webhook->data ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

		// update as processed.
		$webhook->update( [ 'processed_at' => current_time( 'mysql' ) ] );

		// update.
		return $webhook;
	}

	/**
	 * Replace our dot notation webhook with underscore.
	 *
	 * @param string $type The event type.
	 * @return string
	 */
	public function createEventName( $type = '' ) {
		$type = str_replace( '.', '_', $type );
		return "surecart/$type";
	}
}
