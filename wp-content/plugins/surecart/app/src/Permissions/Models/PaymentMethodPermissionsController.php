<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\PaymentMethod;

/**
 * Handle various payment methods permissions.
 */
class PaymentMethodPermissionsController extends ModelPermissionsController {
	/**
	 * Can user read
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
	public function edit_sc_payment_method( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_payment_methods'] ) ) {
			return true;
		}
		return $this->belongsToUser( PaymentMethod::class, $args[2], $user );
	}

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
	public function read_sc_payment_methods( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_payment_methods'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? [] );
	}
}
