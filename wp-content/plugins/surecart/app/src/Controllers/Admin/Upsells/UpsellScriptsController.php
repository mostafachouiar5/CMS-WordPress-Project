<?php

namespace SureCart\Controllers\Admin\Upsells;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Bump Page
 */
class UpsellScriptsController extends AdminModelEditController {
	/**
	 * What types of data to add the the page.
	 *
	 * @var array
	 */
	protected $with_data = [ 'currency', 'supported_currencies', 'tax_protocol', 'checkout_page_url' ];

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/upsell-funnels';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/upsell-funnels';


	/**
	 * Add the app url to the data.
	 */
	public function __construct() {
		$this->data['api_url'] = \SureCart::requests()->getBaseUrl();
	}

	/**
	 * Enqueue the script.
	 */
	public function enqueue() {
		$available_templates              = wp_get_theme()->get_page_templates( null, 'sc_upsell' );
		$available_templates['']          = apply_filters( 'default_page_template_title', __( 'Theme Layout', 'surecart' ), 'rest-api' );
		$this->data['availableTemplates'] = $available_templates;
		parent::enqueue();
	}
}
