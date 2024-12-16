<?php

namespace SureCart\Controllers\Admin;

use SureCart\Models\Account as AccountModel;

/**
 * Handles account actions.
 */
class Account {

	/**
	 * Show the account page.
	 *
	 * @param \SureCartCore\Requests\RequestInterface $request Request.
	 *
	 * @return mixed
	 */
	public function show( \SureCartCore\Requests\RequestInterface $request ) {
		$account = AccountModel::find();

		return \SureCart::view( 'admin.settings.account' )->with(
			[
				'tab'      => $request->query( 'tab' ),
				'name'     => $account->name,
				'currency' => $account->currency,
			]
		);
	}
}
