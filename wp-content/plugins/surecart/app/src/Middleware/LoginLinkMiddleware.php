<?php

namespace SureCart\Middleware;

use SureCart\Models\CustomerLink;
use SureCart\Models\User;
use Closure;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for customer dashboard.
 */
class LoginLinkMiddleware {
	/**
	 * Handle the middleware.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return method
	 */
	public function handle( $request, Closure $next ) {
		$link_id = $request->query( 'customer_link_id' );

		// use original page view if no customer link id is found.
		if ( ! $link_id ) {
			return $next( $request );
		}

		// get the customer link by id.
		$link = CustomerLink::with( [ 'customer' ] )->find( $link_id );
		if ( is_wp_error( $link ) || false !== $link->expired ) {
			return $next( $request );
		}

		// login the user using the customer id from the link.
		$user = $link->getUser();
		if ( $user ) {
			$user->login();
			return $next( $request );
		}

		$user = User::getUserBy( 'email', $link->customer->email );
		if ( $user ) {
			$user->login();
			return $next( $request );
		}

		// there's no user with this email or customer id. Let's create one.
		if ( $link->customer->email ?? false ) {
			$user = User::create(
				[
					'user_name'  => sanitize_user( $link->customer->email, true ),
					'user_email' => $link->customer->email,
				]
			);

			// handle error creating user.
			if ( is_wp_error( $user ) ) {
				return $user;
			}

			if ( $user ) {
				$linked = $user->setCustomerId( $link->customer->id, $link->customer->live_mode ? 'live' : 'test' );
				if ( is_wp_error( $linked ) ) {
					return $next( $request );
				}
				$user->login();
				return $next( $request );
			}
		}

		return $next( $request );
	}
}
