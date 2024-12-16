<?php
/**
 * @package   SureCartAppCore
 * @author    SureCart <support@surecart.com>
 * @copyright  SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com
 */

namespace SureCartAppCore\Application;

use SureCartAppCore\AppCore\AppCore;

/**
 * Can be applied to your App class via a "@mixin" annotation for better IDE support.
 * This class is not meant to be used in any other capacity.
 *
 * @codeCoverageIgnore
 */
final class ApplicationMixin {
	/**
	 * Prevent class instantiation.
	 */
	private function __construct() {}

	/**
	 * Get the Theme service instance.
	 *
	 * @return AppCore
	 */
	public static function core() {}
}
