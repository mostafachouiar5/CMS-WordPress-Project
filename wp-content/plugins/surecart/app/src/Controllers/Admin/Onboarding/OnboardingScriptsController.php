<?php

namespace SureCart\Controllers\Admin\Onboarding;

use SureCart\Support\Scripts\AdminModelEditController;

/**
 * Onboarding Page
 */
class OnboardingScriptsController extends AdminModelEditController {
	/**
	 * Script handle.
	 *
	 * @var string
	 */
	protected $handle = 'surecart/scripts/admin/onboarding';

	/**
	 * Script path.
	 *
	 * @var string
	 */
	protected $path = 'admin/onboarding';

	/**
	 * Include supported currencies.
	 *
	 * @var array
	 */
	protected $with_data = [ 'supported_currencies' ];

	/**
	 * Add additional data.
	 *
	 * @return void
	 */
	public function enqueue() {
		$this->data['connect_url'] = esc_url(
			add_query_arg(
				[
					'onboarding' => [
						'account_name'      => get_bloginfo( 'name' ),
						'account_url'       => get_site_url(),
						'return_url'        => esc_url_raw( admin_url( 'admin.php?page=sc-complete-signup' ) ),
						'account_time_zone' => wp_timezone_string(),
					],
				],
				untrailingslashit( SURECART_APP_URL ) . '/session/new'
			)
		);
		$this->data['user_email']  = is_user_logged_in() ? wp_get_current_user()->user_email : '';
		$this->data['success_url'] = esc_url_raw( \SureCart::getUrl()->index( 'products' ) );

		parent::enqueue();
	}
}
