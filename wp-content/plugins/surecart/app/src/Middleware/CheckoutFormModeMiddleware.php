<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;

/**
 * Middleware for handling checkout mode.
 */
class CheckoutFormModeMiddleware {
	/**
	 * Handle the request.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		// Check nonce.
		if ( ! $request->query( 'nonce' ) || ! wp_verify_nonce( $request->query( 'nonce' ), 'update_checkout_mode' ) ) {
			wp_die( esc_html__( 'Your session expired - please try again.', 'surecart' ) );
		}

		// Check permission to edit the post.
		if (
			! current_user_can( 'edit_post', $request->query( 'sc_checkout_post' ) ) ||
			! current_user_can( 'edit_post', $request->query( 'sc_checkout_change_mode' ) )
		) {
			wp_die( esc_html__( 'You do not have permission do this.', 'surecart' ) );
		}

		return $next( $request );
	}
}
