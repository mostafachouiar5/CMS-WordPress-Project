<?php

namespace SureCart\Rest;

use SureCart\Controllers\Rest\InvoicesController;
use SureCart\Rest\RestServiceInterface;

/**
 * Service provider for Invoice Rest Requests
 */
class InvoicesRestServiceProvider extends RestServiceProvider implements RestServiceInterface {
	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint = 'invoices';

	/**
	 * Rest Controller
	 *
	 * @var string
	 */
	protected $controller = InvoicesController::class;

	/**
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function registerRoutes() {
		parent::registerRoutes();

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/make_draft/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'makeDraft' ),
					'permission_callback' => [ $this, 'draft_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);

		register_rest_route(
			"$this->name/v$this->version",
			$this->endpoint . '/(?P<id>\S+)/open/',
			[
				[
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => $this->callback( $this->controller, 'open' ),
					'permission_callback' => [ $this, 'open_permissions_check' ],
				],
				// Register our schema callback.
				'schema' => [ $this, 'get_item_schema' ],
			]
		);
	}

	/**
	 * Get permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_item_permissions_check( $request ) {
		return current_user_can( 'read_sc_invoice', $request['id'], $request->get_params() );
	}

	/**
	 * List permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can( 'read_sc_invoices', $request->get_params() );
	}

	/**
	 * Create permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'publish_sc_invoices' );
	}

	/**
	 * Update permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_sc_invoices' );
	}

	/**
	 * Delete permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'delete_sc_invoices' );
	}

	/**
	 * Draft permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function draft_permissions_check( $request ) {
		return current_user_can( 'edit_sc_invoices', $request['id'], $request->get_params() );
	}

	/**
	 * Open permissions.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return true|\WP_Error True if the request has access to create items, WP_Error object otherwise.
	 */
	public function open_permissions_check( $request ) {
		return current_user_can( 'edit_sc_invoices', $request['id'], $request->get_params() );
	}
}
