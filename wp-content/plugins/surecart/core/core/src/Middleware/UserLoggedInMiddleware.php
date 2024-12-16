<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Middleware;

use Closure;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\ResponseService;

/**
 * Redirect non-logged in users to a specific URL.
 */
class UserLoggedInMiddleware {
	/**
	 * Response service.
	 *
	 * @var ResponseService
	 */
	protected $response_service = null;

	/**
	 * Constructor.
	 *
	 * @codeCoverageIgnore
	 * @param ResponseService $response_service
	 */
	public function __construct( ResponseService $response_service ) {
		$this->response_service = $response_service;
	}

	/**
	 * {@inheritDoc}
	 */
	public function handle( RequestInterface $request, Closure $next, $url = '' ) {
		if ( is_user_logged_in() ) {
			return $next( $request );
		}

		if ( empty( $url ) ) {
			$url = wp_login_url( $request->getUrl() );
		}

		$url = apply_filters( 'surecart.middleware.user.logged_in.redirect_url', $url, $request );

		return $this->response_service->redirect( $request )->to( $url );
	}
}
