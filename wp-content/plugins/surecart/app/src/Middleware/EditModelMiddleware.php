<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for handling model archiving.
 */
class EditModelMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @param string           $model_name Model name.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next, $model_name ) {
		// check nonce.
		if ( ! $request->query( 'nonce' ) || ! wp_verify_nonce( $request->query( 'nonce' ), "edit_$model_name" ) ) {
			wp_die( __( 'Your session expired - please try again.', 'surecart' ) );
		}

		if ( ! current_user_can( "edit_sc_{$model_name}s" ) ) {
			wp_die( __( 'You do not have permission do this.', 'surecart' ) );
		}

		return $next( $request );
	}
}
