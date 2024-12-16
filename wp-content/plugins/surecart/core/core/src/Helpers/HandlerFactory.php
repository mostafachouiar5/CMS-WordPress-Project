<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart
 */

namespace SureCartCore\Helpers;

use Closure;
use SureCartCore\Application\GenericFactory;

/**
 * Handler factory.
 */
class HandlerFactory {
	/**
	 * Injection Factory.
	 *
	 * @var GenericFactory
	 */
	protected $factory = null;

	/**
	 * Constructor.
	 *
	 * @codeCoverageIgnore
	 * @param GenericFactory $factory
	 */
	public function __construct( GenericFactory $factory ) {
		$this->factory = $factory;
	}

	/**
	 * Make a Handler.
	 *
	 * @codeCoverageIgnore
	 * @param  string|Closure $raw_handler
	 * @param  string         $default_method
	 * @param  string         $namespace
	 * @return Handler
	 */
	public function make( $raw_handler, $default_method = '', $namespace = '' ) {
		return new Handler( $this->factory, $raw_handler, $default_method, $namespace );
	}
}
