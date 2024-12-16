<?php
namespace SureCart\Integrations\ThriveAutomator;

use Thrive\Automator\Items\App;

/**
 * Register our app.
 */
class ThriveAutomatorApp extends App {
	/**
	 * App ID
	 *
	 * @return string
	 */
	public static function get_id() {
		return 'surecart';
	}

	/**
	 * App name
	 *
	 * @return string
	 */
	public static function get_name() {
		return __( 'SureCart', 'surecart' );
	}

	/**
	 * The description for the app.
	 *
	 * @return string
	 */
	public static function get_description() {
		return __( 'SureCart eCommerce Platform', 'surecart' );
	}

	/**
	 * Logo url
	 *
	 * @return string
	 */
	public static function get_logo() {
		return esc_url( trailingslashit( plugin_dir_url( SURECART_PLUGIN_FILE ) ) . 'app/src/Integrations/ThriveAutomator/images/icon-color.svg' );
	}

	/**
	 * Whether the current App is available for the current user
	 * e.g prevent premium items from being shown to free users
	 *
	 * @return bool
	 */
	public static function has_access() {
		return true;
	}
}
