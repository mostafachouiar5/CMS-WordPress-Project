<?php
/**
 * SureEmails core integrations file
 *
 * @since 1.0.0
 * @package SureTrigger
 */

namespace SureTriggers\Integrations\SureEmails;

use SureTriggers\Controllers\IntegrationsController;
use SureTriggers\Integrations\Integrations;
use SureTriggers\Traits\SingletonLoader;
use SureEmails\Loader;

/**
 * Class SureTrigger
 *
 * @package SureTriggers\Integrations\SureEmails
 */
class SureEmails extends Integrations {


	use SingletonLoader;

	/**
	 * ID
	 *
	 * @var string
	 */
	protected $id = 'SureEmails';

	/**
	 * SureTrigger constructor.
	 */
	public function __construct() {
		$this->name        = __( 'SureEmails', 'suretriggers' );
		$this->description = __( 'A simple yet powerful way to create modern forms for your website.', 'suretriggers' );
		$this->icon_url    = SURE_TRIGGERS_URL . 'assets/icons/SureEmails.svg';

		parent::__construct();
	}

	/**
	 * Is Plugin depended plugin is installed or not.
	 *
	 * @return bool
	 */
	public function is_plugin_installed() {
		return class_exists( Loader::class );
	}

}

IntegrationsController::register( SureEmails::class );
