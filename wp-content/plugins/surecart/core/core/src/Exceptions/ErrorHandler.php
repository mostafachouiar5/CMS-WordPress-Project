<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Exceptions;

use Exception as PhpException;
use SureCartVendors\Psr\Http\Message\ResponseInterface;
use Whoops\RunInterface;
use SureCartCore\Csrf\InvalidCsrfTokenException;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Responses\ResponseService;
use SureCartCore\Routing\NotFoundException;
use SureCartCore\Support\Arr;

class ErrorHandler implements ErrorHandlerInterface {
	/**
	 * Response service.
	 *
	 * @var ResponseService
	 */
	protected $response_service = null;

	/**
	 * Pretty handler.
	 *
	 * @var RunInterface|null
	 */
	protected $whoops = null;

	/**
	 * Whether debug mode is enabled.
	 *
	 * @var boolean
	 */
	protected $debug = false;

	/**
	 * Constructor.
	 *
	 * @codeCoverageIgnore
	 * @param ResponseService   $response_service
	 * @param RunInterface|null $whoops
	 * @param boolean           $debug
	 */
	public function __construct( $response_service, $whoops, $debug = false ) {
		$this->response_service = $response_service;
		$this->whoops           = $whoops;
		$this->debug            = $debug;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @codeCoverageIgnore
	 */
	public function register() {
		if ( $this->whoops !== null ) {
			$this->whoops->register();
		}
	}

	/**
	 * {@inheritDoc}
	 *
	 * @codeCoverageIgnore
	 */
	public function unregister() {
		if ( $this->whoops !== null ) {
			$this->whoops->unregister();
		}
	}

	/**
	 * Convert an exception to a ResponseInterface instance if possible.
	 *
	 * @param  PhpException $exception
	 * @return ResponseInterface|false
	 */
	protected function toResponse( $exception ) {
		// @codeCoverageIgnoreStart
		if ( $exception instanceof InvalidCsrfTokenException ) {
			wp_nonce_ays( '' );
		}
		// @codeCoverageIgnoreEnd

		if ( $exception instanceof NotFoundException ) {
			return $this->response_service->error( 404 );
		}

		return false;
	}

	/**
	 * Convert an exception to a debug ResponseInterface instance if possible.
	 *
	 * @throws PhpException
	 * @param  RequestInterface $request
	 * @param  PhpException     $exception
	 * @return ResponseInterface
	 */
	protected function toDebugResponse( RequestInterface $request, PhpException $exception ) {
		if ( $request->isAjax() ) {
			return $this->response_service->json(
				[
					'message'   => $exception->getMessage(),
					'exception' => get_class( $exception ),
					'file'      => $exception->getFile(),
					'line'      => $exception->getLine(),
					'trace'     => array_map(
						function ( $trace ) {
							return Arr::except( $trace, [ 'args' ] );
						},
						$exception->getTrace()
					),
				]
			)->withStatus( 500 );
		}

		if ( $this->whoops !== null ) {
			return $this->toPrettyErrorResponse( $exception );
		}

		throw $exception;
	}

	/**
	 * Convert an exception to a pretty error response.
	 *
	 * @codeCoverageIgnore
	 * @param  PhpException $exception
	 * @return ResponseInterface
	 */
	protected function toPrettyErrorResponse( $exception ) {
		$method = RunInterface::EXCEPTION_HANDLER;
		ob_start();
		$this->whoops->$method( $exception );
		$response = ob_get_clean();
		return $this->response_service->output( $response )->withStatus( 500 );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws PhpException
	 */
	public function getResponse( RequestInterface $request, PhpException $exception ) {
		$response = $this->toResponse( $exception );

		if ( $response !== false ) {
			return $response;
		}

		if ( ! defined( 'SURECART_TEST_DIR' ) ) {
			// Only log errors if we are not running the WP Emerge test suite.
			error_log( $exception );
		}

		if ( ! $this->debug ) {
			return $this->response_service->error( 500 );
		}

		return $this->toDebugResponse( $request, $exception );
	}
}
