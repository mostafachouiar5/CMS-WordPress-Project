<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart
 */

namespace SureCartCore\Routing\Conditions;

use SureCartCore\Requests\RequestInterface;

/**
 * Check against the current post's id.
 *
 * @codeCoverageIgnore
 */
class PostIdCondition implements ConditionInterface, UrlableInterface {
	/**
	 * Post id to check against
	 *
	 * @var integer
	 */
	protected $post_id = 0;

	/**
	 * Constructor
	 *
	 * @codeCoverageIgnore
	 * @param integer $post_id
	 */
	public function __construct( $post_id ) {
		$this->post_id = (int) $post_id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isSatisfied( RequestInterface $request ) {
		return ( is_singular() && $this->post_id === (int) get_the_ID() );
	}

	/**
	 * {@inheritDoc}
	 */
	public function getArguments( RequestInterface $request ) {
		return [ 'post_id' => $this->post_id ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function toUrl( $arguments = [] ) {
		return get_permalink( $this->post_id );
	}
}
