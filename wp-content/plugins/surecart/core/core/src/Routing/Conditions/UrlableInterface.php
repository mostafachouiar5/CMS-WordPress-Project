<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Routing\Conditions;

/**
 * Interface signifying that an object can be converted to a URL.
 */
interface UrlableInterface {
	/**
	 * Convert to URL.
	 *
	 * @param  array $arguments
	 * @return string
	 */
	public function toUrl( $arguments = [] );
}
