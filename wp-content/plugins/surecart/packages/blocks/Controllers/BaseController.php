<?php
namespace SureCartBlocks\Controllers;

use SureCart\Models\User;

/**
 * Base controller for dashboard pages.
 */
abstract class BaseController {
	/**
	 * The middleware for this controller.
	 *
	 * @var array
	 */
	protected $middleware = array();

	/**
	 * Block controller middleware.
	 *
	 * @param  string[] $middleware Middleware.
	 * @param  string   $action Action.
	 * @param  Closure  $next Next.
	 *
	 * @return function
	 */
	public function executeMiddleware( $middleware, $action = null, $next = null ) {
		$next       = null === $next ? $action : $next;
		
		if ( empty( $this->middleware[ $action ] ) && null === $middleware ) {
			return $this->$next();
		}

		$middleware = null === $middleware ? $this->middleware[ $action ] : $middleware;

		$top_middleware = array_shift( $middleware );

		if ( null === $top_middleware ) {
			return $this->$next();
		}

		$top_middleware_next = function () use ( $middleware, $action, $next ) {
			return $this->executeMiddleware( $middleware, $action, $next );
		};

		$instance = new $top_middleware();

		return call_user_func_array( array( $instance, 'handle' ), array( $action, $top_middleware_next ) );
	}

	/**
	 * Handle the request.
	 *
	 * @param string $action The action.
	 *
	 * @return $this
	 */
	public function handle( $action ) {
		return $this->executeMiddleware( null, $action );
	}

	/**
	 * Get a query param.
	 *
	 * @param string $name The query param name.
	 * @param mixed  $fallback The fallback value.
	 *
	 * @return string|false
	 */
	protected function getParam( $name, $fallback = false ) {
		return isset( $_GET[ $name ] ) ? sanitize_text_field( wp_unslash( $_GET[ $name ] ) ) : $fallback;
	}

	/**
	 * Get the current tab.
	 *
	 * @return string|false
	 */
	protected function getTab() {
		return $this->getParam( 'tab' );
	}

	/**
	 * Get the current page.
	 *
	 * @return integer
	 */
	protected function getPage() {
		return $this->getParam( 'page', 1 );
	}

	/**
	 * Get the current id.
	 *
	 * @return integer|false
	 */
	protected function getId() {
		return $this->getParam( 'id' );
	}

	/**
	 * Get the users customer ids.
	 *
	 * @return array
	 */
	protected function customerIds() {
		return array_values( (array) User::current()->customerIds() );
	}

	/**
	 * Render not found view.
	 *
	 * @return string
	 */
	protected function notFound() {
		return '<sc-alert type="danger" open>' . esc_html__( 'Not found.', 'surecart' ) . '</sc-alert>';
	}

	/**
	 * Render not found view.
	 *
	 * @return string
	 */
	protected function noAccess() {
		return '<sc-alert type="danger" open>' . esc_html__( 'You do not have permission to do this.', 'surecart' ) . '</sc-alert>';
	}

	/**
	 * Check if this is in live mode.
	 *
	 * @return boolean
	 */
	protected function isLiveMode() {
		if ( 'false' === sanitize_text_field( wp_unslash( $_GET['live_mode'] ?? '' ) ) ) {
			return false;
		}
		return true;
	}
}
