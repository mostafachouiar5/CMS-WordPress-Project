<?php

namespace SureCart\Permissions\Models;

use SureCart\Models\User;

/**
 * Model permissions abstract class.
 */
abstract class ModelPermissionsController {
	/**
	 * Get the customer id for the user
	 *
	 * @param int $user_id User ID.
	 * @return string Customer ID.
	 */
	protected function getCustomerId( $user_id ) {
		return User::find( $user_id )->customerId();
	}

	/**
	 * Meta caps for models
	 *
	 * @param bool[]   $allcaps Array of key/value pairs where keys represent a capability name
	 *                          and boolean values represent whether the user has that capability.
	 * @param string[] $caps    Required primitive capabilities for the requested capability.
	 * @param array    $args {
	 *     Arguments that accompany the requested capability check.
	 *
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 Optional second and further parameters, typically object ID.
	 * }
	 * @param WP_User  $user    The user object.
	 * @return string[] Primitive capabilities required of the user.
	 */
	public function handle( $allcaps, $caps, $args, $user ) {
		$name = $caps[0] ?? false;
		if ( $name && method_exists( $this, $name ) ) {
			$user = User::find( $user->ID );
			if ( ! $user ) {
				return false;
			}

			// check permission.
			$permission = $this->$name( $user, $args, $allcaps );
			if ( $permission ) {
				$allcaps[ $caps[0] ] = true;
				return $allcaps;
			}
		}

		return $allcaps;
	}

	/**
	 * Does the model belong to the user?
	 *
	 * @param string                $model Model name.
	 * @param string                $id Model ID.
	 * @param \SureCart\Models\User $user User model.
	 * @return boolean
	 */
	public function belongsToUser( $model, $id, $user ) {
		$model = $model::find( $id );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		return $model->belongsToUser( $user );
	}

	/**
	 * Is ths user listing their own customer ids.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $customer_ids Array of customer ids.
	 * @return boolean
	 */
	protected function isListingOwnCustomerIds( $user, $customer_ids ) {
		// must have list.
		if ( empty( $customer_ids ) ) {
			return false;
		}

		// check each one.
		foreach ( $customer_ids as $id ) {
			if ( ! $id || ! in_array( $id, (array) $user->customerIds() ) ) {
				return false; // this id does not belong to the user.
			}
		}

		return true;
	}

	/**
	 * Check permissions for specific properties of the request.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @param array            $keys Keys to check.
	 *
	 * @return boolean
	 */
	protected function requestOnlyHasKeys( $request, $keys ) {
		$keys = array_merge( $keys, [ 'context', '_locale', 'rest_route', 'id', 'expand', 't' ] );
		foreach ( (array) $request as $key => $value ) {
			if ( ! in_array( $key, $keys, true ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Check permissions for specific properties of the request (has keys).
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @param array            $keys Keys to check.
	 *
	 * @return boolean
	 */
	protected function requestHasKeys( $request, $keys ) {
		foreach ( (array) $request as $key => $value ) {
			if ( in_array( $key, $keys, true ) ) {
				return true;
			}
		}
		return false;
	}
}
