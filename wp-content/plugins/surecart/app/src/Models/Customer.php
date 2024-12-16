<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasBillingAddress;
use SureCart\Models\Traits\HasPurchases;
use SureCart\Models\Traits\HasShippingAddress;

/**
 * Price model
 */
class Customer extends Model {
	use HasPurchases;
	use HasShippingAddress;
	use HasBillingAddress;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'customers';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'customer';

	/**
	 * Create a new model
	 *
	 * @param array   $attributes Attributes to create.
	 * @param boolean $create_user Whether to create a corresponding WordPress user.
	 *
	 * @return $this|\WP_Error|false
	 */
	protected function create( $attributes = [], $create_user = true ) {
		/** @var Customer|\WP_Error $customer */
		$customer = parent::create( $attributes );
		if ( $this->isError( $customer ) ) {
			return $customer;
		}

		// maybe create a WordPress user.
		if ( $create_user ) {
			// Find the user by email.
			$user = User::getUserBy( 'email', $this->attributes['email'] );

			// if no user, create one.
			if ( empty( $user ) ) {
				$user = User::create(
					[
						'user_name'  => $this->attributes['name'] ?? null,
						'first_name' => $this->attributes['first_name'] ?? null,
						'last_name'  => $this->attributes['last_name'] ?? null,
						'user_email' => $this->attributes['email'],
					]
				);
			}

			// handle error creating user.
			if ( is_wp_error( $user ) ) {
				return $user;
			}

			$linked = $user->setCustomerId( $this->attributes['id'], $this->live_mode ? 'live' : 'test' );

			if ( is_wp_error( $linked ) ) {
				return $linked;
			}
		}

		return $this;
	}

	/**
	 * Delete the model.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return $this|\WP_Error|false
	 */
	protected function delete( $id = 0 ) {
		$customer = self::find( $id );
		$deleted  = parent::delete( $id );

		if ( ! is_wp_error( $deleted ) ) {
			$user = User::findByCustomerId( $id );

			if ( $user ) {
				if ( is_wp_error( $customer ) ) {
					return $customer;
				}

				$user->removeCustomerId( $customer->live_mode ? 'live' : 'test' );
			}
		}

		return $deleted;
	}

	/**
	 * Expose media for a customer
	 *
	 * @param string $media_id The media id.
	 *
	 * @return \SureCart\Models\Media|false;
	 */
	protected function exposeMedia( $media_id ) {
		if ( empty( $this->attributes['id'] ) || empty( $media_id ) ) {
			return false;
		}

		if ( $this->fireModelEvent( 'exposing_media' ) === false ) {
			return false;
		}

		$media = \SureCart::request(
			$this->endpoint . '/' . $this->attributes['id'] . '/expose/' . $media_id,
			[
				'method' => 'GET',
				'query'  => $this->query,
			]
		);

		if ( $this->isError( $media ) ) {
			return $media;
		}

		$this->fireModelEvent( 'exposed_media' );

		return new Media( $media );
	}

	/**
	 * Get a customer by their email address
	 *
	 * @param string $email Email address.
	 * @return this
	 */
	protected function byEmail( $email ) {
		return $this->where(
			[
				'email' => $email,
			]
		)->first();
	}

	/**
	 * Get the customer's user.
	 *
	 * @return \SureCart\Models\User|false
	 */
	public function getUser() {
		return User::findByCustomerId( $this->id );
	}

	/**
	 * Create the user from the customer.
	 *
	 * @return \SureCart\Models\User|\WP_Error
	 */
	public function createUser() {
		if ( empty( $this->id ) && empty( $this->email ) ) {
			return new \WP_Error( 'no_customer_id_or_email', __( 'No customer ID or email provided.', 'surecart' ) );
		}

		// if no user, create one with a password if provided.
		$created = User::create(
			[
				'user_name'  => $this->name ?? $this->checkout->name ?? null,
				'user_email' => $this->email,
				'first_name' => $this->first_name ?? null,
				'last_name'  => $this->last_name ?? null,
				'phone'      => $this->phone ?? null,
			]
		);

		if ( is_wp_error( $created ) ) {
			return $created;
		}

		$created->setCustomerId( $this->id, ! empty( $this->live_mode ) ? 'live' : 'test' );

		return $created;
	}

	/**
	 * Maybe also return the user when the id is set.
	 *
	 * @param string $value The user id.
	 * @return void
	 */
	public function setIdAttribute( $value ) {
		$this->attributes['id'] = $value;
		if ( ! empty( $this->query['expand'] ) && in_array( 'user', $this->query['expand'] ) ) {
			$this->attributes['user'] = $this->getUser();
		}
	}

	/**
	 * Get the billing address attribute
	 *
	 * @return array|null The billing address.
	 */
	public function getBillingAddressDisplayAttribute() {
		if ( $this->billing_matches_shipping ) {
			return $this->shipping_address;
		}

		return $this->attributes['billing_address'] ?? null;
	}
}
