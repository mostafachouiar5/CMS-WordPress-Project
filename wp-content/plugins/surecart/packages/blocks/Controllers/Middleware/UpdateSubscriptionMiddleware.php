<?php
namespace SureCartBlocks\Controllers\Middleware;

use Closure;
use SureCart\Models\PaymentIntent;
use SureCart\Models\Subscription;

/**
 * Middleware for handling model archiving.
 */
class UpdateSubscriptionMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param string  $action Action.
	 * @param Closure $next Next.
	 * @return function
	 */
	public function handle( string $action, Closure $next ) {
		// check for the payment intent.
		$payment_intent = $_GET['payment_intent'] ?? null; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( empty( $payment_intent ) ) {
			return $next();
		}

		$intent = PaymentIntent::where( [ 'refresh_status' => true ] )->find( $payment_intent );
		if ( is_wp_error( $intent ) ) {
			return wp_die( wp_kses_post( $intent->get_error_message() ) );
		}
		if ( empty( $intent->payment_method ) ) {
			return wp_die( esc_html__( 'Payment method not found.', 'surecart' ) );
		}

		// update the subscription.
		$subscription = Subscription::with(
			[
				'price',
				'price.product',
				'product.product_group',
				'current_period',
				'period.checkout',
				'purchase',
				'discount',
				'discount.coupon',
				'purchase.license',
				'license.activations',
			]
		)->update(
			[
				'id'             => sanitize_text_field( wp_unslash( $_GET['id'] ?? '' ) ),
				'payment_method' => $intent->payment_method,
			]
		);
		if ( is_wp_error( $subscription ) ) {
			return wp_die( wp_kses_post( $subscription->get_error_message() ) );
		}

		return $next();
	}

	/**
	 * Get the intent from the url.
	 *
	 * @return \WP_Error|\SureCart\Models\PaymentIntent;
	 */
	public function getIntentFromUrl() {
		$intent_id = sanitize_text_field( wp_slash( $_GET['payment_intent'] ?? null ) );
		if ( empty( $intent_id ) ) {
			return false;
		}
		return ! empty( $intent_id ) ? PaymentIntent::find( $intent_id ) : null;
	}
}
