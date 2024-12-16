<?php
/**
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

namespace SureCartAppCore\AppCore;

use SureCartCore\Application\Application;

/**
 * Main communication channel with the theme.
 */
class AppCore {
	/**
	 * Application instance.
	 *
	 * @var Application
	 */
	protected $app = null;

	/**
	 * Constructor.
	 *
	 * @param Application $app
	 */
	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * Shortcut to \SureCartAppCore\Assets\Assets.
	 *
	 * @return \SureCartAppCore\Assets\Assets
	 */
	public function assets() {
		return $this->app->resolve( 'surecart_app_core.assets.assets' );
	}

	/**
	 * Shortcut to \SureCartAppCore\Avatar\Avatar.
	 *
	 * @return \SureCartAppCore\Avatar\Avatar
	 */
	public function avatar() {
		return $this->app->resolve( 'surecart_app_core.avatar.avatar' );
	}

	/**
	 * Shortcut to \SureCartAppCore\Config\Config.
	 *
	 * @return \SureCartAppCore\Config\Config
	 */
	public function config() {
		return $this->app->resolve( 'surecart_app_core.config.config' );
	}

	/**
	 * Shortcut to \SureCartAppCore\Image\Image.
	 *
	 * @return \SureCartAppCore\Image\Image
	 */
	public function image() {
		return $this->app->resolve( 'surecart_app_core.image.image' );
	}

	/**
	 * Shortcut to \SureCartAppCore\Sidebar\Sidebar.
	 *
	 * @return \SureCartAppCore\Sidebar\Sidebar
	 */
	public function sidebar() {
		return $this->app->resolve( 'surecart_app_core.sidebar.sidebar' );
	}
}
