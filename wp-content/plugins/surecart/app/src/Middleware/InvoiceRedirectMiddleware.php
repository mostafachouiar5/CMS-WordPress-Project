<?php
namespace SureCart\Middleware;

use Closure;
use SureCart\Models\Invoice;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\RedirectResponse;

/**
 * Middleware for handling invoice redirects.
 */
class InvoiceRedirectMiddleware {
	/**
	 * Handle the invoice redirect.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next middleware.
	 *
	 * @return RedirectResponse|\SureCartVendors\Psr\Http\Message\ResponseInterface
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		$id = $request->query( 'invoice_id' );

		// no invoice id, next request.
		if ( empty( $id ) ) {
			return $next( $request );
		}

		// Find the invoice and redirect to the invoice's checkout
		$invoice = Invoice::find($id);

		// show error if the invoice is not found.
		if ( is_wp_error( $invoice ) ) {
			return wp_die( wp_kses_post( $invoice->get_error_message() ) );
		}

		// show error if the invoice does not have a checkout id.
		if ( empty( $invoice->id ) ) {
			return wp_die( esc_html__( 'Invoice not found.', 'surecart' ) );
		}

		// show error if the invoice checkout is not found.
		if ( empty( $invoice->checkout_id ) ) {
			return wp_die( esc_html__( 'Invoice checkout not found.', 'surecart' ) );
		}

		// redirect to the invoice's checkout.
		return ( new RedirectResponse( $request ) )->to(
			add_query_arg(
				[
					'checkout_id' => $invoice->checkout_id,
				],
				\SureCart::getUrl()->checkout()
			)
		);
	}
}
