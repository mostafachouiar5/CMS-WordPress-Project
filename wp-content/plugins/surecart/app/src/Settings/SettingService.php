<?php

namespace SureCart\Settings;

use SureCart\WordPress\RecaptchaValidationService;
use SureCart\Routing\PermalinksSettingsService;

/**
 * A service for registering settings.
 */
class SettingService {
	/**
	 * Boostrap settings.
	 *
	 * @return void
	 */
	public function bootstrap() {
		$this->register(
			'surecart',
			'theme',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'light',
			]
		);
		$this->register(
			'surecart',
			'auto_sync_user_to_customer',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => false,
			]
		);
		$this->register(
			'surecart',
			'honeypot_enabled',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => true,
			]
		);
		$this->register(
			'surecart',
			'recaptcha_enabled',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
			]
		);
		$this->register(
			'surecart',
			'recaptcha_site_key',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$this->register(
			'surecart',
			'recaptcha_secret_key',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$this->register(
			'surecart',
			'recaptcha_min_score',
			[
				'type'              => 'number',
				'show_in_rest'      => true,
				'default'           => 0.5,
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$this->register(
			'surecart',
			'load_stripe_js',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
			]
		);
		$this->register(
			'surecart',
			'tracking_confirmation',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
			]
		);
		$this->register(
			'surecart',
			'tracking_confirmation_message',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'default'           => esc_html__( 'Your email and cart are saved so we can send email reminders about this order.', 'surecart' ),
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$this->register(
			'surecart',
			'buy_link_logo_width',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'default'           => '180px',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$this->register(
			'surecart',
			'cart_menu_alignment',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'right',
			]
		);
		$this->register(
			'surecart',
			'cart_menu_always_shown',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => true,
			]
		);
		$this->register(
			'surecart',
			'cart_menu_selected_ids',
			[
				'type'         => 'array',
				'items'        => 'integer',
				'show_in_rest' => [
					'schema' => [
						'type'  => 'array',
						'items' => [
							'type' => 'integer',
						],
					],
				],
			]
		);
		$this->register(
			'surecart',
			'cart_icon',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'shopping-bag', // shopping-bag, shopping-cart.
			]
		);
		$this->register(
			'surecart',
			'cart_icon_type',
			[
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'floating_icon', // both, floating_icon, menu_icon.
			]
		);
		$this->register(
			'surecart',
			'password_validation_enabled',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => false,
			]
		);
		$this->register(
			'surecart',
			'shop_admin_menu',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => true,
			]
		);
		$this->register(
			'surecart',
			'cart_admin_menu',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => true,
			]
		);
		$this->register(
			'surecart',
			'checkout_admin_menu',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => true,
			]
		);
		$this->register(
			'surecart',
			'dashboard_admin_menu',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
				'default'           => true,
			]
		);
		$this->register(
			'surecart',
			'unrestricted_test_mode',
			[
				'type'              => 'boolean',
				'show_in_rest'      => true,
				'sanitize_callback' => 'boolval',
			]
		);
	}

	/**
	 * Register a setting.
	 *
	 * @param string $option_group A settings group name. Should correspond to an allowed option key name.
	 *                             Default allowed option key names include 'surecart', 'discussion', 'media',
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
	public function register( $option_group, $option_name, $args = [] ) {
		$service = new RegisterSettingService( $option_group, $option_name, $args );
		return $service->register();
	}

	/**
	 * Recaptcha service.
	 *
	 * @return RecaptchaValidationService
	 */
	public function recaptcha() {
		return new RecaptchaValidationService();
	}

	/**
	 * Get the option.
	 *
	 * @return mixed
	 */
	public function get( $name, $default = false ) {
		return get_option( 'surecart_' . $name, $default );
	}

	/**
	 * Get the permalinks settings.
	 *
	 * @return PermalinksSettingsService
	 */
	public function permalinks() {
		return new PermalinksSettingsService();
	}
}
