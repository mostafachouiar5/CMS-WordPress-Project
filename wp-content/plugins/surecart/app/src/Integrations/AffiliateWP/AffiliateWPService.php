<?php

namespace SureCart\Integrations\AffiliateWP;

use SureCart\Integrations\AffiliateWP\AffiliateWPIntegration;
use SureCart\Integrations\AffiliateWP\AffiliateWPRecurringIntegration;

/**
 * Controls the LearnDash integration.
 */
class AffiliateWPService {
	/**
	 * Bootstrap the integration.
	 *
	 * @return void
	 */
	public function bootstrap() {
		add_filter( 'affwp_extended_integrations', [ $this, 'register' ] );

		add_action(
			'plugins_loaded',
			function() {
				if ( class_exists( 'Affiliate_WP_Recurring_Base' ) ) {
					new AffiliateWPRecurringIntegration();
				}
			}
		);
	}

	/**
	 * Register the integration
	 *
	 * @param array $integrations Integrations.
	 *
	 * @return array
	 */
	public function register( $integrations ) {
		$integrations['surecart'] = [
			'name'     => __( 'SureCart', 'surecart' ),
			'class'    => AffiliateWPIntegration::class,
			'file'     => dirname( __FILE__ ) . '/AffiliateWPIntegration.php',
			'supports' => [ 'sales_reporting' ],
		];
		return $integrations;
	}
}
