<?php
/**
 * @package   SureCartCore
 * @author    SureCart <support@surecart.com>
 * @copyright 2017-2019 SureCart
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @link      https://surecart.com/
 */

namespace SureCartCore\Routing;

use SureCartVendors\Pimple\Container;
use SureCartCore\Routing\Conditions\ConditionFactory;
use SureCartCore\ServiceProviders\ExtendsConfigTrait;
use SureCartCore\ServiceProviders\ServiceProviderInterface;

/**
 * Provide routing dependencies
 *
 * @codeCoverageIgnore
 */
class RoutingServiceProvider implements ServiceProviderInterface {
	use ExtendsConfigTrait;

	/**
	 * Key=>Class dictionary of condition types
	 *
	 * @var array<string, string>
	 */
	protected static $condition_types = [
		'url'           => Conditions\UrlCondition::class,
		'custom'        => Conditions\CustomCondition::class,
		'multiple'      => Conditions\MultipleCondition::class,
		'negate'        => Conditions\NegateCondition::class,
		'post_id'       => Conditions\PostIdCondition::class,
		'post_slug'     => Conditions\PostSlugCondition::class,
		'post_status'   => Conditions\PostStatusCondition::class,
		'post_template' => Conditions\PostTemplateCondition::class,
		'post_type'     => Conditions\PostTypeCondition::class,
		'query_var'     => Conditions\QueryVarCondition::class,
		'ajax'          => Conditions\AjaxCondition::class,
		'admin'         => Conditions\AdminCondition::class,
	];

	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		$this->extendConfig(
			$container,
			'routes',
			[
				'web'   => [
					'definitions' => '',
					'attributes'  => [
						'middleware' => [ 'web' ],
						'namespace'  => 'App\\Controllers\\Web\\',
						'handler'    => 'SureCartCore\\Controllers\\WordPressController@handle',
					],
				],
				'admin' => [
					'definitions' => '',
					'attributes'  => [
						'middleware' => [ 'admin' ],
						'namespace'  => 'App\\Controllers\\Admin\\',
					],
				],
				'ajax'  => [
					'definitions' => '',
					'attributes'  => [
						'middleware' => [ 'ajax' ],
						'namespace'  => 'App\\Controllers\\Ajax\\',
					],
				],
			]
		);

		/** @var Container $container */
		$container[ SURECART_ROUTING_CONDITION_TYPES_KEY ] = static::$condition_types;

		$container[ SURECART_ROUTING_ROUTER_KEY ] = function ( $c ) {
			return new Router(
				$c[ SURECART_ROUTING_CONDITIONS_CONDITION_FACTORY_KEY ],
				$c[ SURECART_HELPERS_HANDLER_FACTORY_KEY ]
			);
		};

		$container[ SURECART_ROUTING_CONDITIONS_CONDITION_FACTORY_KEY ] = function ( $c ) {
			return new ConditionFactory( $c[ SURECART_ROUTING_CONDITION_TYPES_KEY ] );
		};

		$container[ SURECART_ROUTING_ROUTE_BLUEPRINT_KEY ] = $container->factory(
			function ( $c ) {
				return new RouteBlueprint( $c[ SURECART_ROUTING_ROUTER_KEY ], $c[ SURECART_VIEW_SERVICE_KEY ] );
			}
		);

		$app = $container[ SURECART_APPLICATION_KEY ];
		$app->alias( 'route', SURECART_ROUTING_ROUTE_BLUEPRINT_KEY );
		$app->alias( 'routeUrl', SURECART_ROUTING_ROUTER_KEY, 'getRouteUrl' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		// Nothing to bootstrap.
	}
}
