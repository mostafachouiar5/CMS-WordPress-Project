<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;

/**
 * Middleware for handling model archiving.
 */
class UpsellMiddleware {
	/**
	 * Handle the request.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		if ( empty( $request->query( 'sc_checkout_id' ) ) && ! current_user_can( 'edit_sc_orders' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'surecart' ), esc_html__( 'Error', 'surecart' ), [ 'response' => 403 ] );
		}

		return $next( $request );
	}
}
