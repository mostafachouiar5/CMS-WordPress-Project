<?php
namespace SureCart\Models;

use ArrayAccess;
use JsonSerializable;
use SureCart\Models\Traits\SyncsCustomer;

/**
 * User class.
 */
class User implements ArrayAccess, JsonSerializable {
	use SyncsCustomer;
	/**
	 * Holds the user.
	 *
	 * @var \WP_User|null;
	 */
	protected $user;

	/**
	 * Holds the cutomser
	 *
	 * @var \SureCart\Models\Customer;
	 */
	protected $customer;

	/**
	 * Stores the customer id key.
	 *
	 * @var string
	 */
	protected $customer_id_key = 'sc_customer_ids';

	/**
	 * Get the customer meta key.
	 *
	 * @return string
	 */
	protected function getCustomerMetaKey() {
		return $this->customer_id_key;
	}

	/**
	 * Get the user's customer id.
	 *
	 * @param string $mode Customer mode.
	 *
	 * @return int|null
	 */
	protected function customerId( $mode = 'live' ) {
		if ( empty( $this->user->ID ) ) {
			return null;
		}
		$meta = (array) get_user_meta( $this->user->ID, $this->customer_id_key, true );
		if ( isset( $meta[ $mode ] ) ) {
			return $meta[ $mode ];
		}
		if ( isset( $meta[0] ) ) {
			return $meta[0];
		}
		return null;
	}

	/**
	 * Sync the customer ids.
	 *
	 * @return array Array of synced items.
	 */
	protected function syncCustomerIds() {
		// syncing disabled.
		if ( ! $this->shouldSyncCustomer() ) {
			return false;
		}

		// get all customers by email address (live and test).
		$customers = Customer::where(
			[
				'email' => strtolower( $this->user->user_email ),
			]
		)->get();

		if ( is_wp_error( $customers ) ) {
			return $customers;
		}

		// we have customers.
		$live_customer = current(
			array_filter(
				$customers,
				function( $customer ) {
					return $customer->live_mode;
				}
			)
		);

		$test_customer = current(
			array_filter(
				$customers,
				function( $customer ) {
					return ! $customer->live_mode;
				}
			)
		);

		if ( empty( $live_customer->id ) ) {
			$live_customer = Customer::create(
				[
					'name'      => $this->user->display_name,
					'email'     => strtolower( $this->user->user_email ),
					'live_mode' => true,
				],
				false // don't create a user.
			);
		}
		if ( empty( $test_customer->id ) ) {
			$test_customer = Customer::create(
				[
					'name'      => $this->user->display_name,
					'email'     => strtolower( $this->user->user_email ),
					'live_mode' => false,
				],
				false // don't create a user.
			);
		}

		if ( ! empty( $live_customer->id ) ) {
			$this->setCustomerId( $live_customer->id, 'live' );
		}
		if ( ! empty( $test_customer->id ) ) {
			$this->setCustomerId( $test_customer->id, 'test' );
		}

		return [
			'live' => $this->customerId( 'live' ),
			'test' => $this->customerId( 'test' ),
		];
	}

	/**
	 * List the users customer ids.
	 *
	 * @return array
	 */
	protected function customerIds() {
		if ( empty( $this->user->ID ) ) {
			return [];
		}
		return array_filter( (array) get_user_meta( $this->user->ID, $this->customer_id_key, true ) );
	}

	/**
	 * Is this user a customer?
	 *
	 * @return boolean
	 */
	protected function isCustomer() {
		return ! empty( array_filter( (array) $this->customerIds() ) );
	}

	/**
	 * Does the user have this customer id?
	 *
	 * @param string $id The customer id.
	 *
	 * @return boolean
	 */
	protected function hasCustomerId( $id ) {
		foreach ( (array) $this->customerIds() as $saved_id ) {
			if ( $saved_id === $id ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Set the customer id in the user meta.
	 *
	 * @param string $id Customer id.
	 * @return $this|bool
	 */
	protected function setCustomerId( $id, $mode = 'live', $force = false ) {
		$meta = (array) get_user_meta( $this->user->ID, $this->customer_id_key, true );

		// if we are setting something here.
		if ( ! empty( $id ) ) {
			// if they already have one set for this mode.
			if ( ! empty( $meta[ $mode ] ) ) {
				// if we have not passed force = true.
				if ( ! $force ) {
					return new \WP_Error( 'already_linked', __( 'This user is already linked to a customer.', 'surecart' ) );
				}
			}
		}

		// update id.
		$meta[ $mode ] = $id;
		// update meta.
		update_user_meta( $this->user->ID, $this->customer_id_key, $meta );
		return $this;
	}

	/**
	 * Remove the the customer id from the user meta.
	 *
	 * @param string $mode Customer mode.
	 * @return $this
	 */
	protected function removeCustomerId( $mode = 'live' ) {
		$meta = (array) get_user_meta( $this->user->ID, $this->customer_id_key, true );

		// if we are setting something here.
		if ( ! empty( $meta[ $mode ] ) ) {
			// set mode empty.
			unset( $meta[ $mode ] );
		}

		// update meta.
		update_user_meta( $this->user->ID, $this->customer_id_key, $meta );

		// return this.
		return $this;
	}

	/**
	 * Disallow overriding the constructor in child classes and make the code safe that way.
	 */
	final public function __construct() {
	}

	/**
	 * Get a user's subscriptions
	 *
	 * @return mixed
	 */
	protected function subscriptions() {
		return Subscription::where( [ 'customer_ids' => [ $this->customerId() ] ] );
	}

	/**
	 * Get a users orders
	 *
	 * @param array $query Query args.
	 * @return SureCart\Models\Order[];
	 */
	protected function orders() {
		return Order::where( [ 'customer_ids' => [ $this->customerId() ] ] );
	}

	/**
	 * Login the user.
	 *
	 * @return true|\WP_Error
	 */
	protected function login() {
		if ( empty( $this->user->ID ) ) {
			return new \Error( 'not_found', esc_html__( 'This user could not be found.', 'surecart' ) );
		}

		clean_user_cache( $this->user->ID );
		wp_clear_auth_cookie();
		wp_set_current_user( $this->user->ID );
		wp_set_auth_cookie( $this->user->ID );
		update_user_caches( $this->user );

		return true;
	}

	/**
	 * Create a new user and return this model context
	 * If the user already exists, just set the customer and role in that case.
	 */
	protected function create( $args ) {
		$args = wp_parse_args(
			$args,
			[
				'user_name'     => '',
				'user_email'    => '',
				'user_password' => '',
				'first_name'    => '',
				'last_name'     => '',
			]
		);

		// use the username or the email as a fallback.
		$name     = ! empty( sanitize_user( $args['user_name'], true ) ) ? sanitize_user( $args['user_name'], true ) : $args['user_email'];
		$username = $this->createUniqueUsername( sanitize_user( $name, true ) );

		$user_password = trim( $args['user_password'] );
		$user_created  = false;

		// password is not provided.
		if ( empty( $user_password ) ) {
			$user_password = wp_generate_password( 12, false );
			$user_id       = wp_create_user( sanitize_user( $username, true ), $user_password, $args['user_email'] );
			// turn off this feature with a filter.
			if ( apply_filters( 'surecart/default_password_nag', true, $user_id ) ) {
				update_user_meta( $user_id, 'default_password_nag', true );
			}
			$user_created = true;
		} else {
			// Password has been provided.
			$user_id      = wp_create_user( sanitize_user( $username, true ), $user_password, $args['user_email'] );
			$user_created = true;
		}

		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}

		$user = new \WP_User( $user_id );
		$user->add_role( 'sc_customer' );

		if ( $args['first_name'] ) {
			$user->first_name = $args['first_name'];
		}
		if ( $args['last_name'] ) {
			$user->last_name = $args['last_name'];
		}

		if ( $user_created ) {
			wp_update_user( $user );
		}

		return $this->find( $user_id );
	}

	/**
	 * Create a unique username for the user.
	 *
	 * @param string $name The username.
	 *
	 * @return string
	 */
	protected function createUniqueUsername( $name ) {
		$base_name = $name;
		$i         = 0;
		while ( username_exists( $name ) ) {
			$name = $base_name . ( ++$i );
		}
		return $name;
	}

	/**
	 * Retrieve user info by a given field
	 *
	 * @param string     $field The field to retrieve the user with. id | ID | slug | email | login.
	 * @param int|string $value A value for $field. A user ID, slug, email address, or login name.
	 * @return this|false This object on success, false on failure.
	 */
	protected function getUserBy( $field, $value ) {
		$this->user = get_user_by( $field, $value ?? '' );
		return $this->user ? $this : false;
	}

	/**
	 * Get the customer from the user.
	 *
	 * @return \SureCart\Models\Customer|false
	 */
	protected function customer( $mode = 'live' ) {
		$id = $this->customerId( $mode );
		if ( ! $id ) {
			return false;
		}
		return Customer::find( $this->customerId( $mode ) );
	}

	/**
	 * Get the current user
	 *
	 * @return $this
	 */
	protected function current() {
		$this->user = wp_get_current_user();
		return $this;
	}

	/**
	 * Find the user.
	 *
	 * @param integer $id ID of the WordPress user.
	 * @return $this
	 */
	protected function find( $id ) {
		$this->user = get_user_by( 'id', $id );
		return $this;
	}

	/**
	 * Find the user by customer id.
	 *
	 * @param string $id Customer id string.
	 * @return $this
	 */
	protected function findByCustomerId( $id ) {
		if ( ! is_string( $id ) || empty( $id ) ) {
			return false;
		}

		$users = new \WP_User_Query(
			[
				'meta_query' => [
					[
						'key'     => $this->customer_id_key,
						'value'   => $id,
						'compare' => 'LIKE',
					],
				],
			]
		);

		if ( empty( $users->results ) ) {
			return false;
		}

		$this->user = $users->results[0];
		return $this;
	}

	/**
	 * Get the WordPress user.
	 *
	 * @return \WP_User|null;
	 */
	public function getWPUser() {
		return $this->user;
	}

	/**
	 * Get a specific attribute
	 *
	 * @param string $key Attribute name.
	 *
	 * @return mixed
	 */
	public function getAttribute( $key ) {
		$attribute = null;

		if ( $this->hasAttribute( $key ) ) {
			$attribute = $this->user->$key;
		}

		return $attribute;
	}

	/**
	 * Sets a user attribute
	 * Optionally calls a mutator based on set{Attribute}Attribute
	 *
	 * @param string $key Attribute key.
	 * @param mixed  $value Attribute value.
	 *
	 * @return mixed|void
	 */
	public function setAttribute( $key, $value ) {
		$this->user->$key = $value;
	}

	/**
	 * Does it have the attribute
	 *
	 * @param string $key Attribute key.
	 *
	 * @return boolean
	 */
	public function hasAttribute( $key ) {
		return $this->user->$key ?? false;
	}

	/**
	 * Serialize to json.
	 *
	 * @return Array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return $this->user->to_array();
	}

	/**
	 * Get the attribute
	 *
	 * @param string $key Attribute name.
	 *
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->getAttribute( $key );
	}

	/**
	 * Set the attribute
	 *
	 * @param string $key Attribute name.
	 * @param mixed  $value Value of attribute.
	 *
	 * @return void
	 */
	public function __set( $key, $value ) {
		$this->setAttribute( $key, $value );
	}

	/**
	 * Determine if the given attribute exists.
	 *
	 * @param  mixed $offset Name.
	 * @return bool
	 */
	public function offsetExists( $offset ): bool {
		return ! is_null( $this->getAttribute( $offset ) );
	}

	/**
	 * Get the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet( $offset ) {
		return $this->getAttribute( $offset );
	}

	/**
	 * Set the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @param  mixed $value Value.
	 * @return void
	 */
	public function offsetSet( $offset, $value ): void {
		$this->setAttribute( $offset, $value );
	}

	/**
	 * Unset the value for a given offset.
	 *
	 * @param  mixed $offset Name.
	 * @return void
	 */
	public function offsetUnset( $offset ) : void {
		$this->user->$offset = null;
	}

	/**
	 * Get the user object.
	 *
	 * @return \WP_User|null
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Determine if an attribute or relation exists on the model.
	 *
	 * @param  string $key Name.
	 * @return bool
	 */
	public function __isset( $key ) {
		return $this->offsetExists( $key );
	}

	/**
	 * Unset an attribute on the model.
	 *
	 * @param  string $key Name.
	 * @return void
	 */
	public function __unset( $key ) {
		$this->offsetUnset( $key );
	}

	/**
	 * Forward call to method
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 */
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this, $method ], $params );
	}

	/**
	 * Static Facade Accessor
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $params ) {
		return call_user_func_array( [ new static(), $method ], $params );
	}
}
