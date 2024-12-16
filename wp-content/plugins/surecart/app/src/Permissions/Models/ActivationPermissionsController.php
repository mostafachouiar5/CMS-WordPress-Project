<?php
namespace SureCart\Permissions\Models;

use SureCart\Models\Activation;

/**
 * Handle various charge permissions.
 */
class ActivationPermissionsController extends ModelPermissionsController {
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
	public function read_sc_activation( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_products'] ) ) {
			return true;
		}
		return $this->belongsToUser( Activation::class, $args[2], $user );
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
	public function read_sc_activations( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['read_sc_products'] ) ) {
			return true;
		}
		return $this->isListingOwnCustomerIds( $user, $args[2]['customer_ids'] ?? [] );
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
	public function edit_sc_activation( $user, $args, $allcaps ) {
		if ( ! empty( $allcaps['edit_sc_products'] ) ) {
			return true;
		}

		// only allowed to update the fingerprint.
		$params = $args[3];
		if ( ! $this->requestOnlyHasKeys( $params, array( 'fingerprint' ) ) ) {
			return false;
		}

		// only allowed to update if it belongs to the user.
		return $this->belongsToUser( Activation::class, $args[2], $user );
	}

	/**
	 * Publish
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
	public function publish_sc_activations( $user, $args, $allcaps ) {
		return ! empty( $allcaps['publish_sc_products'] );
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
		$model = $model::with( [ 'license' ] )->find( $id );
		if ( is_wp_error( $model ) ) {
			return $model;
		}
		if ( ! $model->license ) {
			return false;
		}
		return $model->license->belongsToUser( $user );
	}
}
