<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Responses;

use SureCartVendors\Psr\Http\Message\ResponseInterface;

interface ResponsableInterface {
	/**
	 * Convert to SureCartVendors\Psr\Http\Message\ResponseInterface.
	 *
	 * @return ResponseInterface
	 */
	public function toResponse();
}
