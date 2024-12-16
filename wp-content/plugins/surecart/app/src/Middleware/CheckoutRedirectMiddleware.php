<?php

namespace SureCart\Middleware;

use Closure;
use SureCart\Models\Checkout;
use SureCart\Models\Product;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for handling model archiving.
 */
class CheckoutRedirectMiddleware {
	/**
	 * Enqueue component assets.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		$id = $request->query( 'checkout_id' );

		// no checkout id, next request.
		if ( empty( $id ) ) {
			return $next( $request );
		}

		$checkout = Checkout::find( $id );

		// get checkout from page id.
		if ( ! empty( $checkout->metadata->buy_page_product_id ) ) {
			$product = Product::find( $checkout->metadata->buy_page_product_id );
			// handle error.
			if ( is_wp_error( $product ) ) {
				wp_die( esc_html( $product->get_error_message() ) );
			}

			// buy link disabled and person cannot view.
			if ( ! $product->buyLink()->isEnabled() && ! current_user_can( 'edit_sc_products' ) ) {
				wp_die( esc_html__( 'This product is not available for purchase.', 'surecart' ) );
			}

			$url = $product->buyLink()->url();
			if ( $url ) {
				return ( new RedirectResponse( $request ) )->to(
					esc_url_raw( $this->buildUrl( $url, $request ) )
				);
			}
		}

		// get checkout from page id.
		if ( ! empty( $checkout->metadata->page_id ) ) {
			$url = get_permalink( (int) $checkout->metadata->page_id );
			if ( $url ) {
				return ( new RedirectResponse( $request ) )->to(
					esc_url_raw( $this->buildUrl( $url, $request ) )
				);
			}
		}

		// get checkout from page_url.
		if ( ! empty( $checkout->metadata->page_url ) ) {
			return ( new RedirectResponse( $request ) )->to(
				esc_url_raw( $this->buildUrl( $checkout->metadata->page_url, $request ) )
			);
		}

		// these don't exist, use the default checkout page.
		if ( ! empty( \SureCart::pages()->url( 'checkout' ) ) ) {
			return ( new RedirectResponse( $request ) )->to(
				esc_url_raw( $this->buildUrl( \SureCart::pages()->url( 'checkout' ), $request ) )
			);
		}

		// cannot find checkout page.
		return $next( $request );
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
