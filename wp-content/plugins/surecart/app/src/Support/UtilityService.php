<?php

namespace SureCart\Support;

use SureCart\Support\Blocks\TemplateUtilityService;

class UtilityService {
	/**
	 * Service container.
	 *
	 * @var \Pimple\Container
	 */
	protected $container;

	/**
	 * UtilityService constructor.
	 *
	 * @param \Pimple\Container $container Service container.
	 */
	public function __construct( $container ) {
		$this->container = $container;
	}

	/**
	 * Get the block template utility service.
	 *
	 * @return TemplateUtilityService
	 */
	public function blockTemplates() {
		$root_path = trailingslashit( $this->container[ SURECART_CONFIG_KEY ]['app_core']['path'] ) . '/templates/';
		return new TemplateUtilityService( $root_path . 'templates', $root_path . 'parts' );
	}

	/**
	 * Holds the color service.
	 *
	 * @return ColorService
	 */
	public function color() {
		return new ColorService();
	}
}
