<?php

namespace SureCart\Controllers\Admin\Settings;

/**
 * Controls the settings page.
 */
class BrandSettings extends BaseSettings {
	/**
	 * Script handles for pages
	 *
	 * @var array
	 */
	protected $scripts = [
		'show' => [ 'surecart/scripts/admin/brand', 'admin/settings/brand' ],
	];
}
