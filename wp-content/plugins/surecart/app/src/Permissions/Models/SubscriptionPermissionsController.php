<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\Subscription;

/**
 * Handle various permissions.
 */
class SubscriptionPermissionsController extends ModelPermissionsController {
	/**
	 * Subscription cancelation.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 The quantity to update.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 *
	 * @return boolean
	 */
	public function cancel_sc_subscription( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_subscriptions'] ) ) {
			return true;
		}

		// It's disabled on the account.
		if ( empty( \SureCart::account()->customer_portal_protocol->subscription_cancellations_enabled ) ) {
			return false;
		}

		// if we should delay cancellation.
		$subscription = Subscription::find( $args[2] );
		if ( $subscription->shouldDelayCancellation() ) {
			return false;
		}

		return $this->belongsToUser( Subscription::class, $args[2], $user );
	}

	/**
	 * Subscription restoring.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 The quantity to update.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 *
	 * @return boolean
	 */
	public function restore_sc_subscription( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_subscriptions'] ) ) {
			return true;
		}

		return $this->belongsToUser( Subscription::class, $args[2], $user );
	}

	/**
	 * Subscription Update Quantity.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 The quantity to update.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 *
	 * @return boolean
	 */
	public function update_sc_subscription_quantity( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_subscriptions'] ) ) {
			return true;
		}

		$subscription = Subscription::find( $args[2] );

		if ( empty( \SureCart::account()->customer_portal_protocol->subscription_quantity_updates_enabled ) ) {
			$subscription = Subscription::find( $args[2] );
			if ( is_wp_error( $subscription ) ) {
				return false;
			}

			$quantity = $args[3];

			// quantities don't match.
			if ( $subscription->quantity !== $quantity ) {
				return false;
			}
		}

		return $this->belongsToUser( Subscription::class, $args[2], $user );
	}

	/**
	 * Subscription Switch.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 The quantity to update.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 * @return boolean
	 */
	public function switch_sc_subscription( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_subscriptions'] ) ) {
			return true;
		}

		if ( empty( $args[2] ) ) {
			return false;
		}

		// It's disabled on the account.
		if ( empty( \SureCart::account()->customer_portal_protocol->subscription_updates_enabled ) ) {
			return false;
		}

		return $this->belongsToUser( Subscription::class, $args[2], $user );
	}

	/**
	 * Can user read.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 Optional second and further parameters, typically object ID.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 *
	 * @return boolean Does user have permission.
	 */
	public function read_sc_subscription( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_subscriptions'] ) ) {
			return true;
		}
		return $this->belongsToUser( Subscription::class, $args[2], $user );
	}

	/**
	 * Can user list.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type string[]  ...$2 The ids to list.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 *
	 * @return boolean Does user have permission.
	 */
	public function read_sc_subscriptions( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_subscriptions'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? array() );
	}

	/**
	 * Can user edit.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type string    $2 The id of the subscription.
	 *     @type array  ...$4 The data that is being requested to update.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 * @return boolean Does user have permission.
	 */
	public function edit_sc_subscription( $user, $args, $allcaps ) {
		// user has full access.
		if ( ! empty( $allcaps['edit_sc_subscriptions'] ) ) {
			return true;
		}

		// no user to check.
		if ( empty( $user->ID ) ) {
			return false;
		}

		// user is not a customer.
		if ( ! $user->isCustomer() ) {
			return false;
		}

		// no data provided to update. Make sure to at least pass an empty array.
		if ( is_null( $args[3] ?? null ) ) {
			return false;
		}

		$params = $args[3];

		// request has blacklisted keys.
		if ( ! $this->requestOnlyHasKeys( $params, array( 'cancel_at_period_end', 'quantity', 'price', 'purge_pending_update', 'payment_method', 'manual_payment_method', 'manual_payment', 'cancellation_act', 'ad_hoc_amount', 'variant', 'discount' ) ) ) {
			return false;
		}

		// check if they can modify price.
		if ( ! empty( $params['price'] ) && ! $this->switch_sc_subscription( $user, $args, $allcaps ) ) {
			return false;
		}

		if ( ! empty( $params['variant'] ) && ! $this->switch_sc_subscription( $user, $args, $allcaps ) ) {
			return false;
		}

		// check if user can modify quantity.
		if ( ! empty( $params['quantity'] ) && $params['quantity'] > 1 && ! $this->update_sc_subscription_quantity( $user, $args, $allcaps ) ) {
			return false;
		}

		return $this->belongsToUser( Subscription::class, $args[2], $user );
	}
}
