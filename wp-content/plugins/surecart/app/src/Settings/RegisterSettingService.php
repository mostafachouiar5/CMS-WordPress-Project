<?php

namespace SureCart\Settings;

/**
 * Settings registration service.
 */
class RegisterSettingService {
	/**
	 * Our setting prefix.
	 *
	 * @var string
	 */
	protected $prefix = 'surecart_';

	/**
	 * Holds the option group name.
	 *
	 * @var string
	 */
	protected $option_group;

	/**
	 * Holds the option name.
	 *
	 * @var string
	 */
	protected $option_name;

	/**
	 * Holds the options args.
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * Register a setting.
	 *
	 * @param string $option_group A settings group name. Should correspond to an allowed option key name.
	 *                             Default allowed option key names include 'general', 'discussion', 'media',
	 *                             'reading', 'writing', and 'options'.
	 * @param string $option_name The name of an option to sanitize and save.
	 * @param array  $args {
	 *     Data used to describe the setting when registered.
	 *
	 *     @type string     $type              The type of data associated with this setting.
	 *                                         Valid values are 'string', 'boolean', 'integer', 'number', 'array', and 'object'.
	 *     @type string     $description       A description of the data attached to this setting.
	 *     @type callable   $sanitize_callback A callback function that sanitizes the option's value.
	 *     @type bool|array $show_in_rest      Whether data associated with this setting should be included in the REST API.
	 *                                         When registering complex settings, this argument may optionally be an
	 *                                         array with a 'schema' key.
	 *     @type mixed      $default           Default value when calling `get_option()`.
	 */
	public function __construct( $option_group, $option_name, $args = [] ) {
		$this->option_group = $option_group;
		$this->option_name  = $option_name;
		$this->args         = $args;
	}

	/**
	 * Call registration hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_init', [ $this, 'registerSetting' ] );
		add_action( 'rest_api_init', [ $this, 'registerSetting' ] );
	}

	/**
	 * Register the setting
	 *
	 * @return void
	 */
	public function registerSetting() {
		register_setting(
			$this->option_group,
			$this->prefix . $this->option_name,
			$this->args,
		);
	}
}
