<?php

namespace SureCart\Integrations\Beaver;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SureCart form form widget.
 *
 * Surecart widget that displays a form.
 */
class BeaverFormModule extends \FLBuilderModule {
	
	public function __construct() {
        parent::__construct([
            'name'            => __('SureCart Form', 'surecart'),
            'description'     => __('SureCart Form', 'surecart'),
            'group'           => __('SureCart', 'surecart'),
            'category'        => __('SureCart', 'surecart'),
            'dir'             => SURECART_BB_DIR . 'ReusableFormModule/',
            'url'             => SURECART_BB_URL . 'ReusableFormModule/',
            'icon'            => 'button.svg',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ]);

        $this->slug = 'surecart-form';
    }

    /**
     * Should be overridden by subclasses to enqueue
     * additional css/js using the add_css and add_js methods.
     *
     * @since x.x.x
	 *
     * @return void
     */
    public function enqueue_scripts() {
		$this->add_js('surecart-beaver-scripts', plugins_url( 'ReusableFormModule/src/settings.js', __FILE__ ), array( 'jquery' ), time(), true );
	}

	/**
	 * Get settings
	 *
	 * @return array
	 */
    public static function getSettings() {
        $forms     = (array) \SureCart::forms()->get_forms( [ 'numberposts' => -1 ] );
		$form_data = [ 0 => __( 'Select a form', 'surecart' ) ];
		
        foreach ( $forms as $form ) {
			$form_data[ $form->ID ] = get_the_title( $form );
		}

		return [
			'settings' => [
				'title'    => __( 'Settings', 'surecart' ),
				'sections' => [
					'sc_form_select' => [
						'title'  => 'Checkout Forms',
						'fields' => [
							'sc_form_id' => array(
								'type'    => 'select',
								'label'   => __( 'Checkout Form', 'surecart' ),
								'options' => $form_data,
							),
                            'sc_form_select_ajax' => [
                                'type' => 'raw',
                                'content' => self::button_content()
                            ],
						],
					],
				],
			],
		];
    }

	/**
	 * Get buttons content
	 *
	 * @return html
	 */
    public static function button_content() {
        ob_start();
		?>
        <div class="surecart-builder--custom-form-controls" style="text-align: right;">
            <div class="surecart-builder--form-edit-buttons">
                <a href="/wp-admin/post-new.php?post_type=sc_form" class="fl-builder-button surecart-create-bb-form" target="_blank">
                    <?php esc_html_e('Create', 'surecart'); ?>
                </a> &nbsp;
                <a href="#" class="fl-builder-button surecart-edit-bb-form" target="_blank">
                    <?php esc_html_e('Edit', 'surecart'); ?>
                </a>
            </div>
    	<?php
        return ob_get_clean();
    }

    /**
     * Display the block
     *
     * @return void
     */
    public function display() {
		if ( ! $this->settings->sc_form_id ) {
            return;
        }

		echo do_shortcode( '[sc_form id=' . $this->settings->sc_form_id . ']' );
        return;
    }
}
