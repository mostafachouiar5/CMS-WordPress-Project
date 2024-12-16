<?php
/**
 * Plugin service.
 *
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

namespace SureCart\WordPress;

use SureCartCore\Application\Application;

/**
 * Main communication channel with the theme.
 */
class PluginService {
	/**
	 * Application instance.
	 *
	 * @var Application
	 */
	protected $app = null;

	/**
	 * Constructor.
	 *
	 * @param Application $app Application instance.
	 */
	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * Get the plugin version
	 *
	 * @return string
	 */
	public function version() {
		// Load version from plugin data.
		if ( ! \function_exists( 'get_plugin_data' ) ) {
			require_once \ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return \get_plugin_data( SURECART_PLUGIN_FILE, false, false )['Version'];
	}

	/**
	 * Has the plugin version changed?
	 *
	 * @return boolean
	 */
	public function versionChanged() {
		return version_compare( $this->version(), get_option( 'surecart_migration_version', '0.0.0' ), '!=' );
	}

	/**
	 * Shortcute to \SureCart\Account\AccountService
	 *
	 * @return \SureCart\Account\AccountService
	 */
	public function account() {
		return $this->app->resolve( 'surecart.account' );
	}

	/**
	 * Shortcut to \SureCart\Install\InstallService.
	 *
	 * @return \SureCart\Install\InstallService
	 */
	public function install() {
		return $this->app->resolve( 'surecart.install' );
	}

	/**
	 * Shortcut to \SureCart\WordPress\Pages\PageService.
	 *
	 * @return \SureCart\WordPress\Pages\PageService
	 */
	public function pages() {
		return $this->app->resolve( 'surecart.pages' );
	}
	/**
	 * Shortcut to \SureCart\WordPress\Pages\PageService.
	 *
	 * @return \SureCart\WordPress\Pages\PageService
	 */
	public function activation() {
		return $this->app->resolve( 'surecart.activation' );
	}

	/**
	 * Shortcut to \SureCart\WordPress\Pages\PageService.
	 *
	 * @return \SureCart\Permissions\RolesService;
	 */
	public function roles() {
		return $this->app->resolve( 'surecart.permissions.roles' );
	}
}
