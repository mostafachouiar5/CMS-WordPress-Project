<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\View;

/**
 * Interface that view engines must implement
 */
interface ViewEngineInterface extends ViewFinderInterface {
	/**
	 * Create a view instance from the first view name that exists.
	 *
	 * @param  string[] $views
	 * @return ViewInterface
	 */
	public function make( $views );
}
