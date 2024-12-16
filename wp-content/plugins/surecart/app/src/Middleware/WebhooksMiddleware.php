<?php

namespace SureCart\Middleware;

use Closure;
use SureCart\Models\RegisteredWebhook;
use SureCartCore\Requests\RequestInterface;

/**
 * Middleware for handling model archiving.
 */
class WebhooksMiddleware {
	/**
	 * Holds the current request.
	 *
	 * @var  RequestInterface
	 */
	protected $request;

	/**
	 * Handle the middleware.
	 *
	 * @param RequestInterface $request Request.
	 * @param Closure          $next Next.
	 * @return function
	 */
	public function handle( RequestInterface $request, Closure $next ) {
		$this->request = $request;

		if ( ! $this->verifySignature( $request ) ) {
			return \SureCart::json( [ 'error' => 'Invalid signature' ] )->withStatus( 403 );
		}

		return $next( $request );
	}

	/**
	 * Verify the signature.
	 *
	 * @return bool
	 */
	public function verifySignature() {
		return $this->getSignature() === $this->computeHash();
	}

	/**
	 * Compute an HMAC with the SHA256 hash function.
	 * Use the endpoint’s signing secret as the key, and use the signed_payload string as the message.
	 *
	 * @return string
	 */
	public function computeHash() {
		return hash_hmac( 'sha256', $this->getSignedPayload(), $this->getSigningSecret() );
	}

	/**
	 * Get the signing secret.
	 *
	 * @return string
	 */
	public function getSigningSecret() {
		return RegisteredWebhook::getSigningSecret();
	}

	/**
	 * Get expected json request body.
	 *
	 * @return string
	 */
	public function getBody() {
		return file_get_contents( 'php://input' );
	}

	/**
	 * Get the webhook signature.
	 *
	 * @return string
	 */
	public function getSignature() {
		return $this->request->headers( 'X-Webhook-Signature' )[0] ?? $this->request->headers( 'x-webhook-signature' )[0] ?? '';
	}

	/**
	 * Get the webhook timestamp.
	 *
	 * @return string
	 */
	public function getTimestamp() {
		return $this->request->headers( 'X-Webhook-Timestamp' )[0] ?? $this->request->headers( 'x-webhook-timestamp' )[0] ?? '';
	}

	/**
	 * Get the signed payload.
	 *
	 * @return string
	 */
	public function getSignedPayload() {
		return $this->getTimestamp() . '.' . $this->getBody();
	}
}
