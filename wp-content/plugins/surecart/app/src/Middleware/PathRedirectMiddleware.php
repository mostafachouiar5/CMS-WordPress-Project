<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for handling model archiving.
 */
class PathRedirectMiddleware {
	/**
	 * Enqueue component assets.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		$path             = $request->query( 'path' );
		$customer_link_id = $request->query( 'customer_link_id' );

		// need a path and a customer link id.
		if ( empty( $path ) || empty( $customer_link_id ) ) {
			return $next( $request );
		}

		$path = $request->query( 'path' );
		return ( new RedirectResponse( $request ) )->to(
			esc_url_raw( $this->buildUrl( untrailingslashit( get_home_url() ) . $path, $request ) )
		);
	}

	/**
	 * Build the url.
	 *
	 * @return string
	 */
	public function buildUrl( $url, RequestInterface $request ) {
		if ( empty( $url ) ) {
			return $url;
		}

		// add checkout id.
		$id = $request->query( 'checkout_id' );
		if ( $id ) {
			$url = add_query_arg(
				[
					'checkout_id' => $id,
				],
				$url
			);
		}

		$promotion_code = $request->query( 'promotion_code' );
		if ( $promotion_code ) {
			$url = add_query_arg(
				[
					'coupon' => $promotion_code,
				],
				$url
			);
		}

		return $url;
	}
}
