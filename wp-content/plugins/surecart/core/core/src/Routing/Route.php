<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Routing;

use SureCartCore\Exceptions\ConfigurationException;
use SureCartCore\Helpers\HasAttributesTrait;
use SureCartCore\Requests\RequestInterface;
use SureCartCore\Routing\Conditions\ConditionInterface;

/**
 * Represent a route
 */
class Route implements RouteInterface, HasQueryFilterInterface {
	use HasAttributesTrait;
	use HasQueryFilterTrait;

	/**
	 * {@inheritDoc}
	 */
	public function isSatisfied( RequestInterface $request ) {
		$methods   = $this->getAttribute( 'methods', [] );
		$condition = $this->getAttribute( 'condition' );

		if ( ! in_array( $request->getMethod(), $methods ) ) {
			return false;
		}

		if ( ! $condition instanceof ConditionInterface ) {
			throw new ConfigurationException( 'Route does not have a condition.' );
		}

		return $condition->isSatisfied( $request );
	}

	/**
	 * {@inheritDoc}
	 */
	public function getArguments( RequestInterface $request ) {
		$condition = $this->getAttribute( 'condition' );

		if ( ! $condition instanceof ConditionInterface ) {
			throw new ConfigurationException( 'Route does not have a condition.' );
		}

		return $condition->getArguments( $request );
	}
}
