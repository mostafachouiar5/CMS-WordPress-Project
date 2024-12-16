<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Routing;

/**
 * Interface for HasRoutesTrait
 */
interface HasRoutesInterface {
	/**
	 * Get routes.
	 *
	 * @return RouteInterface[]
	 */
	public function getRoutes();

	/**
	 * Add a route.
	 *
	 * @param  RouteInterface $route
	 * @return void
	 */
	public function addRoute( RouteInterface $route );

	/**
	 * Remove a route.
	 *
	 * @param  RouteInterface $route
	 * @return void
	 */
	public function removeRoute( RouteInterface $route );
}
