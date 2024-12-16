<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\Order;

/**
 * Handle various charge permissions.
 */
class OrderPermissionsController extends ModelPermissionsController {
	/**
	 * Can user read.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 Optional second and further parameters, typically object ID.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 * @return boolean Does user have permission.
	 */
	public function read_sc_order( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_orders'] ) ) {
			return true;
		}
		return $this->belongsToUser( Order::class, $args[2], $user );
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
		$order = Order::with( [ 'checkout' ] )->find( $id );
		if ( is_wp_error( $order ) ) {
			return $order;
		}
		return $order->checkout->belongsToUser( $user );
	}

	/**
	 * Can user read.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type mixed  ...$2 Optional second and further parameters, typically object ID.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 * @return boolean Does user have permission.
	 */
	public function read_sc_orders( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_orders'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? [] );
	}
}
