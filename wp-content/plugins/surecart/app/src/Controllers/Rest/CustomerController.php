<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\Customer;
use SureCart\Models\User;

/**
 * Handle Price requests through the REST API
 */
class CustomerController extends RestController {
	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = Customer::class;

	/**
	 * Connect a user.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response
	 */
	public function connect( \WP_REST_Request $request ) {
		$customer = Customer::find( $request['customer_id'] );
		if ( is_wp_error( $customer ) ) {
			return $customer;
		}

		$user = User::find( $request['user_id'] );
		if ( is_wp_error( $user ) ) {
			return $user;
		}

		$response = $user->setCustomerId( $customer->id, $customer->live_mode ? 'live' : 'test', $request['force'] ?? false );
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$controller = new \WP_REST_Users_Controller();
		return rest_ensure_response( $controller->prepare_item_for_response( $user->getUser(), $request ) );
	}

	/**
	 * Sync Users with platform.
	 * This catches the request and enqueues the action to start the sync.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function sync( \WP_REST_Request $request ) {
		// enqueue action.
		return as_enqueue_async_action(
			'surecart/sync/customers',
			[
				'page'        => 1,
				'batch_size'  => apply_filters( 'surecart/sync/customers/batch_size', 100 ),
				'create_user' => $request->get_param( 'create_user' ),
				'run_actions' => $request->get_param( 'run_actions' ),
			],
			'surecart'
		);
	}

	/**
	 * Expose media for a customer.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \SureCart\Models\Media|false
	 */
	public function exposeMedia( \WP_REST_Request $request ) {
		$customer = $this->middleware( new $this->class( $request['id'] ), $request );
		if ( is_wp_error( $customer ) ) {
			return $customer;
		}

		return $customer->where( $request->get_query_params() )->exposeMedia( $request['media_id'] );
	}

	/**
	 * Edit model.
	 *
	 * @param \WP_REST_Request $request Rest Request.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function edit( \WP_REST_Request $request ) {
		$wp_user = User::findByCustomerId( $request['id'] );

		if ( ! empty( $wp_user->ID ) ) {
			wp_update_user(
				[
					'ID'         => $wp_user->ID,
					'user_email' => ! empty( $request['email'] ) ? $request['email'] : $wp_user->user_email,
					'first_name' => ! empty( $request['first_name'] ) ? $request['first_name'] : $wp_user->first_name,
					'last_name'  => ! empty( $request['last_name'] ) ? $request['last_name'] : $wp_user->last_name,
					'phone'      => ! empty( $request['phone'] ) ? $request['phone'] : $wp_user->phone,
				]
			);
		}

		return parent::edit( $request );
	}
}
