<?php

namespace SureCart\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for handling model archiving.
 */
class PaymentFailureRedirectMiddleware {
	/**
	 * Enqueue component assets.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		$payment_id      = $request->query( 'payment_failure_id' );
		$subscription_id = $request->query( 'subscription_id' );

		if ( $payment_id && $subscription_id ) {
			return ( new RedirectResponse( $request ) )->to(
				add_query_arg(
					[
						'action' => 'edit',
						'model'  => 'subscription',
						'id'     => $subscription_id,
						'action' => 'update_payment_method',
					],
					\SureCart::pages()->url( 'dashboard' )
				)
			);
		}

		return $next( $request );
	}
}
