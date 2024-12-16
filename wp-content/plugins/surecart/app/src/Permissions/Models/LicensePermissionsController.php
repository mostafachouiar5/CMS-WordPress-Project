<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\License;

/**
 * Handle various permissions.
 */
class LicensePermissionsController extends ModelPermissionsController {
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
	public function read_sc_license( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_licenses'] ) ) {
			return true;
		}
		return $this->belongsToUser( License::class, $args[2], $user );
	}

	/**
	 * Can user list.
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
	 */
	public function read_sc_licenses( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_licenses'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? [] );
	}

	/**
	 * Use can edit if the can edit licenses.
	 *
	 * @param \SureCart\Models\User $user User model.
	 * @param array                 $args {
	 *                  Arguments that accompany the requested capability check.
	 *     @type string    $0 Requested capability.
	 *     @type int       $1 Concerned user ID.
	 *     @type string    $2 The id of the license.
	 *     @type array  ...$4 The data that is being requested to update.
	 * }
	 * @param bool[]                $allcaps Array of key/value pairs where keys represent a capability name
	 *                                       and boolean values represent whether the user has that capability.
	 * @return boolean Does user have permission.
	 */
	public function edit_sc_license( $user, $args, $allcaps ) {
		return ! empty( $allcaps['edit_sc_licenses'] );
	}
}
