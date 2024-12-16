<?php

namespace SureCart\Controllers\Admin\AffiliationPayoutGroups;

use SureCart\Controllers\Admin\AdminController;

/**
 * Handles affiliate payout groups admin routes.
 */
class AffiliationPayoutGroupsController extends AdminController {

	/**
	 * Edit an affiliate payout group.
	 *
	 * @param \SureCartCore\Http\Request $request Request object.
	 *
	 * @return string
	 */
	public function edit( $request ) {
		// enqueue needed script.
		add_action( 'admin_enqueue_scripts', \SureCart::closure()->method( AffiliationPayoutGroupsScriptsController::class, 'enqueue' ) );

		$this->preloadPaths(
			[
				'/wp/v2/users/me',
				'/wp/v2/types?context=view',
				'/wp/v2/types?context=edit',
				'/surecart/v1/payout_groups/' . $request->query( 'id' ) . '?context=edit',
			]
		);

		// return view.
		return '<div id="app"></div>';
	}
}
