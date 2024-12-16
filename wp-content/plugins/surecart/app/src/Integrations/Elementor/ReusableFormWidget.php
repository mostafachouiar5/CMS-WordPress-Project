<?php

namespace SureCart\Integrations\Elementor;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SureCart form form widget.
 *
 * Surecart widget that displays a form.
 */
class ReusableFormWidget extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * Retrieve form widget name.
	 *
	 * @since x.x.x
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'surecart_form';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve form widget title.
	 *
	 * @since x.x.x
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Checkout Form', 'surecart' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve form widget icon.
	 *
	 * @since x.x.x
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-form-horizontal surecart-checkout-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the form widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since x.x.x
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'surecart-elementor' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since x.x.x
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'form', 'surecart', 'checkout' ];
	}

	/**
	 * Register form widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_form',
			[
				'label' => __( 'Checkout Form', 'surecart' ),
			]
		);

		$options = $this->get_forms_options();

		$this->add_control(
			'sc_form_block',
			[
				'label'   => __( 'Select Form', 'surecart' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'options' => $options,
				'default' => array_keys( $options )[0],
			]
		);

		$this->add_control(
			'sc_edit_form',
			[
				'label' => __( 'Edit Form', 'surecart' ),
				'type'  => \Elementor\Controls_Manager::BUTTON,
				'text'  => __( 'Edit', 'surecart' ),
				'event' => 'surecart:form:edit',
			]
		);

		$this->add_control(
			'sc_create_form',
			[
				'label'     => __( 'Create New Form', 'surecart' ),
				'separator' => 'before',
				'classes'   => 'testclass',
				'type'      => \Elementor\Controls_Manager::BUTTON,
				'text'      => __( 'Create', 'surecart' ),
				'event'     => 'surecart:form:create',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get froms options.
	 *
	 * @since x.x.x
	 *
	 * @return array
	 */
	public function get_forms_options() {
		$args = [
			'numberposts' => -1,
			'fields'      => 'ids',
		];

		$get_forms = \SureCart::forms()->get_forms( $args );

		$options = [];

		foreach ( $get_forms as $form ) {
			$options[ $form ] = get_the_title( $form );
		}

		return $options;
	}

	/**
	 * Render form widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo do_shortcode( '[sc_form id=' . $settings['sc_form_block'] . ']' );
	}
}
