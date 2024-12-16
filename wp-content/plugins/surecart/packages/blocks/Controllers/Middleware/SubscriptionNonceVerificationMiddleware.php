<?php
namespace SureCartBlocks\Controllers\Middleware;

use Closure;

/**
 * Handles nonce check for controller.
 */
class SubscriptionNonceVerificationMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param string  $action Action.
	 * @param Closure $next Next.
	 * @return function
	 */
	public function handle( string $action, Closure $next ) {
		// check nonce.
		if ( ! wp_verify_nonce( $_REQUEST['nonce'] ?? '', 'subscription-switch' ) ) {
			wp_die( esc_html__( 'Your session expired - please try again.', 'surecart' ) );
			exit;
		}

		return $next();
	}
}
