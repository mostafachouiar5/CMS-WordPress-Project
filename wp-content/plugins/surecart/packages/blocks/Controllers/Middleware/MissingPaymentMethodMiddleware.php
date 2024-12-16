<?php
namespace SureCartBlocks\Controllers\Middleware;

use Closure;
use SureCart\Models\Subscription;
use SureCartBlocks\Controllers\PaymentMethodController;

/**
 * Handles a showing a view for the missing payment element.
 * If the subscription is missing it.
 */
class MissingPaymentMethodMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param string  $action Action.
	 * @param Closure $next Next.
	 * @return function
	 */
	public function handle( string $action, Closure $next ) {
		$id  = sanitize_text_field( wp_unslash( $_GET['id'] ?? '' ) );
		$tab = sanitize_text_field( wp_unslash( $_GET['tab'] ?? '' ) );

		// get the subscription.
		$subscription = Subscription::find( $id );

		// no payment method, show the payment method form.
		if ( empty( $subscription->payment_method ) && empty( $subscription->manual_payment_method ) ) {
			$current_url = home_url( add_query_arg( [ 'tab' => esc_attr( $tab ) ] ) );

			return ( new PaymentMethodController() )->create(
				[
					'success_url' => $current_url,
				]
			);
		}

		return $next();
	}
}
