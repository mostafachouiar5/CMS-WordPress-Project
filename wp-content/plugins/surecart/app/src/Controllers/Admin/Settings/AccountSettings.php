<?php

namespace SureCart\Controllers\Admin\Settings;

/**
 * Controls the settings page.
 */
class AccountSettings extends BaseSettings {
	/**
	 * Script handles for pages
	 *
	 * @var array
	 */
	protected $scripts = [
		'show' => [ 'surecart/scripts/admin/account', 'admin/settings/account' ],
	];
}
