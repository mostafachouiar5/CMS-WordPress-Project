<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\Media;

/**
 * Handle various charge permissions.
 */
class MediaPermissionsController extends ModelPermissionsController {
	/**
	 * Can user edit charge.
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
	public function edit_sc_checkout( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_checkouts'] ) ) {
			return true;
		}
		$checkout = Media::find( $args[2] );
		if ( ! $checkout || is_wp_error( $checkout ) ) {
			return false;
		}
		return in_array( $checkout->status, [ 'draft', 'finalized' ] );
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
	public function read_sc_checkout( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_checkouts'] ) ) {
			return true;
		}
		$checkout = Checkout::find( $args[2] );
		if ( in_array( $checkout->status, [ 'draft', 'finalized' ] ) ) {
			return true;
		}
		return $this->belongsToUser( Checkout::class, $args[2], $user );
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
	public function read_sc_checkouts( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_checkouts'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? [] );
	}
}
