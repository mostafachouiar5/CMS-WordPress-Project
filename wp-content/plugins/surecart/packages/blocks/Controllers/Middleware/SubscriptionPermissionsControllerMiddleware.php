<?php
namespace SureCartBlocks\Controllers\Middleware;

use Closure;

/**
 * Handles permissions check for subscription controller.
 */
class SubscriptionPermissionsControllerMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param string  $action Action.
	 * @param Closure $next Next.
	 * @return function
	 */
	public function handle( string $action, Closure $next ) {
		if ( ! current_user_can( 'edit_sc_subscription', $_GET['id'] ?? '', array( 'payment_method' => true ) ) ) {
			return wp_die( esc_html__( 'You do not have permission to edit this subscription.', 'surecart' ) );
		}

		return $next();
	}
}
