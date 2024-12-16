<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;

/**
 * Middleware for handling model archiving.
 */
class BrandColorMiddleware {
	/**
	 * Enqueue component assets.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		\SureCart::assets()->printBrandColors();
		return $next( $request );
	}
}
