<?php

namespace SureCart\Integrations\ThriveAutomator\Triggers;

use SureCart\Integrations\ThriveAutomator\DataObjects\ProductDataObject;
use SureCart\Integrations\ThriveAutomator\ThriveAutomatorApp;
use SureCart\Models\User;
use Thrive\Automator\Items\Data_Object;
use Thrive\Automator\Items\Trigger;

/**
 * Handles the purchase revoked event.
 */
class PurchaseRevokedTrigger extends Trigger {
	/**
	 * Get the trigger identifier
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart_purchase_revoked';
	}

	/**
	 * Get the trigger hook
	 *
	 * @return string
	 */
	public static function get_wp_hook() {
		return 'surecart/purchase_revoked';
	}

	/**
	 * Get the app id.
	 *
	 * @return string
	 */
	public static function get_app_id() {
		return ThriveAutomatorApp::get_id();
	}

	/**
	 * Get the trigger provided params
	 *
	 * @return array
	 */
	public static function get_provided_data_objects() {
		return [ ProductDataObject::get_id(), 'user_data' ];
	}

	/**
	 * Get the number of params
	 *
	 * @return int
	 */
	public static function get_hook_params_number() {
		return 1;
	}

	/**
	 * Get the trigger name
	 *
	 * @return string
	 */
	public static function get_name() {
		return __( 'Product purchase is revoked or subscription cancels', 'surecart' );
	}

	/**
	 * Get the trigger description
	 *
	 * @return string
	 */
	public static function get_description() {
		return __( 'This trigger will be fired when a subscription cancels after failed payment or by customer request, or when the purchase is manually revoked by the merchant.', 'surecart' );
	}

	/**
	 * Get the trigger logo
	 *
	 * @return string
	 */
	public static function get_image() {
		return esc_url( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'app/src/Integrations/ThriveAutomator/images/icon-color.svg' );
	}

	/**
	 * Process params for action.
	 *
	 * @param array $params Params from the action.
	 * @return array
	 */
	public function process_params( $params = [] ) {
		$data_objects = [];

		if ( ! empty( $params ) ) {
			$data_object_classes = Data_Object::get();
			$product_id          = $params[0]['product'];
			$user                = User::findByCustomerId( $params[0]['customer'] );

			$data_objects['surecart_product_data'] = empty( $data_object_classes['surecart_product_data'] ) ? null : new $data_object_classes['surecart_product_data']( $product_id );
			$data_objects['user_data']             = empty( $data_object_classes['user_data'] ) ? null : new $data_object_classes['user_data']( $user->ID );
		}

		return $data_objects;
	}

}
