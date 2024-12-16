<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\View;

use SureCartCore\Responses\ResponsableInterface;

/**
 * Represent and render a view to a string.
 */
interface ViewInterface extends HasContextInterface, ResponsableInterface {
	/**
	 * Get name.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Set name.
	 *
	 * @param  string $name
	 * @return static $this
	 */
	public function setName( $name );

	/**
	 * Render the view to a string.
	 *
	 * @return string
	 */
	public function toString();
}
