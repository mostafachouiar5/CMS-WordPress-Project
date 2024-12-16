<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Routing\Conditions;

use SureCartCore\Requests\RequestInterface;

/**
 * Interface that condition types must implement
 */
interface ConditionInterface {
	/**
	 * Get whether the condition is satisfied
	 *
	 * @param  RequestInterface $request
	 * @return boolean
	 */
	public function isSatisfied( RequestInterface $request );

	/**
	 * Get an array of arguments for use in request
	 *
	 * @param  RequestInterface $request
	 * @return array
	 */
	public function getArguments( RequestInterface $request );
}
