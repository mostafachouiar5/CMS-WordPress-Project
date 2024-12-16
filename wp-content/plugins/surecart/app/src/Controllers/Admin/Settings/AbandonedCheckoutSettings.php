<?php

namespace SureCart\Controllers\Admin\Settings;

/**
 * Controls the settings page.
 */
class AbandonedCheckoutSettings extends BaseSettings {
	/**
	 * Script handles for pages
	 *
	 * @var array
	 */
	protected $scripts = [
		'show' => [ 'surecart/scripts/admin/abandoned', 'admin/settings/abandoned' ],
	];
}
