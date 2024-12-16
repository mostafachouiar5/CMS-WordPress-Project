<?php

namespace SureCart\WordPress\Users;

use SureCart\Models\User;

/**
 * WordPress Users service.
 */
class UsersService {
	/**
	 * Register rest related queries.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_filter( 'rest_user_query', array( $this, 'userMetaQuery' ), 10, 2 );
		add_filter( 'rest_user_query', array( $this, 'isCustomerQuery' ), 10, 2 );
		add_filter( 'rest_user_collection_params', array( $this, 'collectionParams' ) );
		add_filter( 'show_admin_bar', array( $this, 'disableAdminBar' ), 10, 1 );
		add_action( 'profile_update', array( $this, 'syncUserProfile' ), 10, 3 );
		add_action( 'surecart/customer_updated', array( $this, 'syncCustomerProfile' ) );
		$this->registerMeta();
	}

	/**
	 * Fires immediately after an existing customer is updated.
	 *
	 * @param object $customer Customer Data.
	 */
	public function syncCustomerProfile( $customer ) {
		$wp_user = \SureCart\Models\User::findByCustomerId( $customer->id );

		if ( ! empty( $wp_user->ID ) ) {
			// prevent potential infinite loop of catching a webhook and updating again.
			remove_action( 'profile_update', array( $this, 'syncUserProfile' ), 10 );

			// update user.
			wp_update_user(
				array(
					'ID'         => $wp_user->ID,
					'user_email' => ! empty( $customer->email ) ? $customer->email : $wp_user->user_email,
					'first_name' => ! empty( $customer->first_name ) ? $customer->first_name : $wp_user->first_name,
					'last_name'  => ! empty( $customer->last_name ) ? $customer->last_name : $wp_user->last_name,
					'phone'      => ! empty( $customer->phone ) ? $customer->phone : $wp_user->phone,
				)
			);

			// re-add profile_update in case it is done in the same request somewhere.
			add_action( 'profile_update', array( $this, 'syncUserProfile' ), 10 );
		}

		return $wp_user;
	}

	/**
	 * Fires immediately after an existing user is updated.
	 *
	 * @param int     $user_id       User ID.
	 * @param WP_User $old_user_data Object containing user's data prior to update.
	 * @param array   $userdata      The raw array of data passed to wp_insert_user().
	 */
	public function syncUserProfile( $user_id, $old_user_data, $userdata ) {
		$customer_ids = \SureCart\Models\User::find( $user_id )->customerIds();
		if ( is_wp_error( $customer_ids ) || empty( $customer_ids ) ) {
			return;
		}

		foreach ( $customer_ids as $id ) {
			\SureCart\Models\Customer::update(
				array_filter(
					array(
						'id'         => $id,
						'first_name' => $userdata['first_name'],
						'last_name'  => $userdata['last_name'],
						'email'      => $userdata['user_email'],
						'phone'      => $userdata['phone'] ?? null,
					),
					function ( $x ) {
						return null !== $x;
					}
				)
			);
		}
	}

	/**
	 * Prevent any user who cannot 'edit_posts' (subscribers, customers etc) from seeing the admin bar.
	 *
	 * @param bool $show_admin_bar If should display admin bar.
	 * @return bool
	 */
	public function disableAdminBar( $show_admin_bar ) {
		if ( apply_filters( 'surecart_disable_admin_bar', true ) && ! ( current_user_can( 'edit_posts' ) || current_user_can( 'manage_sc_shop_settings' ) ) ) {
			return false;
		}

		return $show_admin_bar;
	}

	/**
	 * Add our query parameters to the rest api.
	 *
	 * @param array $query_params The query parameters.
	 * @return array
	 */
	public function collectionParams( $query_params ) {
		$query_params['is_customer']     = array(
			'description' => __( 'Limit result set to users with a customer.', 'surecart' ),
			'type'        => 'boolean',
		);
		$query_params['sc_customer_ids'] = array(
			'description' => __( 'Limit result set to users with specific customer ids.', 'surecart' ),
			'type'        => 'array',
			'items'       => array(
				'type' => 'string',
			),
		);
		return $query_params;
	}

	/**
	 * Register customer id meta.
	 *
	 * @return void
	 */
	public function registerMeta() {
		register_meta(
			'user',
			'sc_customer_ids',
			array(
				'type'              => 'object',
				'show_in_rest'      => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'live' => array(
								'type' => 'string',
							),
							'test' => array(
								'type' => 'string',
							),
						),
					),
				),
				'single'            => true,
				'sanitize_callback' => function ( $value ) {
					return array_filter( array_map( 'sanitize_text_field', (array) $value ) );
				},
				'auth_callback'     => function () {
					return current_user_can( 'edit_sc_customers' );
				},
			)
		);

		register_meta(
			'user',
			'default_password_nag',
			array(
				'type'         => 'boolean',
				'show_in_rest' => true,
				'single'       => true,
			)
		);
	}

	/**
	 * Allow querying by customer id in the REST API
	 *
	 * @param array            $args Query args.
	 * @param \WP_REST_Request $request Request.
	 * @return array
	 */
	public function userMetaQuery( $args, $request ) {
		$key          = User::getCustomerMetaKey();
		$customer_ids = $request->get_param( 'sc_customer_ids' );

		// we're only concerned about our param.
		if ( empty( $customer_ids ) ) {
			return $args;
		}

		// lets double-check our permissions in case other permissions fail.
		if ( ! current_user_can( 'edit_sc_customers' ) ) {
			return $args;
		}

		// set the meta query.
		$args['meta_query'] = array(
			'relation' => 'OR',
		);

		foreach ( $customer_ids as $customer_id ) {
			$args['meta_query'][] = array(
				'key'     => $key,
				'value'   => $customer_id,
				'compare' => 'LIKE',
			);
		}

		return $args;
	}

	/**
	 * Query only users who are customers or not.
	 *
	 * @param array            $args Query args.
	 * @param \WP_REST_Request $request Request.
	 * @return array
	 */
	public function isCustomerQuery( $args, $request ) {
		$is_customer = $request->get_param( 'is_customer' );
		if ( null === $is_customer ) {
			return $args;
		}

		if ( $is_customer ) {
			// exists and not empty.
			$args['meta_query'] = array(
				'relation' => 'AND',
				array(
					'key'     => User::getCustomerMetaKey(),
					'compare' => 'EXISTS',
				),
				array(
					'key'     => User::getCustomerMetaKey(),
					'value'   => '',
					'compare' => '!=',
				),
			);
		} else {
			$args['meta_query'] = array(
				'relation' => 'OR',
				array(
					'key'     => User::getCustomerMetaKey(),
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => User::getCustomerMetaKey(),
					'value'   => '',
					'compare' => '=',
				),
			);
		}

		return $args;
	}
}
