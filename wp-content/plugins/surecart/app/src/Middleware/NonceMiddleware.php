<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for handling model archiving.
 */
class NonceMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @param string           $model_name Model name.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next, $nonce_name ) {
		// get nonce from body or query.
		$nonce = $request->query( 'nonce' ) ?? $request->body( 'nonce' );

		if ( empty( $nonce ) ) {
			wp_die( esc_html__( 'Something is wrong with the provided link.', 'surecart' ) );
			exit;
		}

		// check nonce.
		if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
			wp_die( esc_html__( 'Your session expired - please try again.', 'surecart' ) );
			exit;
		}

		return $next( $request );
	}
}
