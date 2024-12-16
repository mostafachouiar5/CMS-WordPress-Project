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
 * Negate another condition's result.
 */
class NegateCondition implements ConditionInterface {
	/**
	 * Condition to negate.
	 *
	 * @var ConditionInterface
	 */
	protected $condition = null;

	/**
	 * Constructor.
	 *
	 * @codeCoverageIgnore
	 * @param ConditionInterface $condition
	 */
	public function __construct( $condition ) {
		$this->condition = $condition;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isSatisfied( RequestInterface $request ) {
		return ! $this->condition->isSatisfied( $request );
	}

	/**
	 * {@inheritDoc}
	 */
	public function getArguments( RequestInterface $request ) {
		return $this->condition->getArguments( $request );
	}
}
