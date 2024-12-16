<?php

namespace SureCart\Permissions;

/**
 * Permissions Service
 */
class PermissionsService {
	/**
	 * Register controller permission handlers
	 *
	 * @return void
	 */
	public function bootstrap() {
		$config = \SureCart::resolve( SURECART_CONFIG_KEY );
		if ( ! empty( $config['permission_controllers'] ) ) {
			foreach ( $config['permission_controllers'] as $controller ) {
				$instance = new $controller();
				add_filter( 'user_has_cap', [ $instance, 'handle' ], 10, 4 );
			}
		}
	}
}
