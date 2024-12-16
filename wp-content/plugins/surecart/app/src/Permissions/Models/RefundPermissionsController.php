<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\Refund;

/**
 * Handle various charge permissions.
 */
class RefundPermissionsController extends ModelPermissionsController {
	/**
	 * Can user read multiple.
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
	public function read_sc_charges( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_charges'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? [] );
	}
}
