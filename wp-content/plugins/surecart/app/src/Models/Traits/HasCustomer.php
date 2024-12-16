<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Customer;
use SureCart\Models\User;

/**
 * If the model has an attached customer.
 */
trait HasCustomer {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setCustomerAttribute( $value ) {
		$this->setRelation( 'customer', $value, Customer::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getCustomerIdAttribute() {
		return $this->getRelationId( 'customer' );
	}

	/**
	 * Find out which WordPress user this model belongs to.
	 *
	 * @return \WP_User|false
	 */
	public function getUser() {
		if ( empty( $this->attributes['customer'] ) ) {
			return false;
		}
		if ( is_string( $this->attributes['customer'] ) ) {
			return User::findByCustomerId( $this->attributes['customer'] );
		}
		if ( ! empty( $this->attributes['customer']->id ) ) {
			return User::findByCustomerId( $this->attributes['customer']->id );
		}
		return false;
	}

	/**
	 * Get the WordPress user.
	 *
	 * @return \WP_User|null;
	 */
	public function getWPUser() {
		$user = $this->getUser() ?? null;
		if ( empty( $user->ID ) ) {
			return;
		}
		return $user->getWPUser();
	}

	/**
	 * Get the customer from the user.
	 *
	 * @param \WP_User|int $user_to_check User id or user object to check for ownership.
	 * @return boolean
	 */
	public function belongsToUser( $user_to_check ) {
		// normalize user id/object.
		if ( is_int( $user_to_check ) ) {
			$user_to_check = get_user_by( 'ID', $user_to_check );
		}

		// make sure we can get a user id.
		if ( empty( $user_to_check->ID ) ) {
			return false;
		}

		// get user for this object.
		$user = $this->getUser();
		if ( empty( $user->ID ) ) {
			return false;
		}

		// they must match.
		return $user->ID === $user_to_check->ID;
	}

	/**
	 * Does this belong to the current user?
	 *
	 * @return boolean
	 */
	public function belongsToCurrentUser() {
		return $this->belongsToUser( wp_get_current_user() );
	}
}
