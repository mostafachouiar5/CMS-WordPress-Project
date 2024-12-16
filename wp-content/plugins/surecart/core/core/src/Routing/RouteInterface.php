<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Routing;

use SureCartCore\Helpers\HasAttributesInterface;
use SureCartCore\Requests\RequestInterface;

/**
 * Interface that routes must implement
 */
interface RouteInterface extends HasAttributesInterface {
	/**
	 * Get whether the route is satisfied.
	 *
	 * @param  RequestInterface $request
	 * @return boolean
	 */
	public function isSatisfied( RequestInterface $request );

	/**
	 * Get arguments.
	 *
	 * @param  RequestInterface $request
	 * @return array
	 */
	public function getArguments( RequestInterface $request );
}
