<?php

namespace SureCartBlocks\Blocks\Address;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Address Block.
 */
class Block extends BaseBlock {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content = '' ) {
		$default_country = $attributes['default_country'] ?? null;

		ob_start(); ?>
		<sc-order-shipping-address
			label="<?php echo esc_attr( $attributes['label'] ); ?>"
			<?php echo $attributes['full'] ? 'full' : null; ?>
			<?php echo $attributes['show_name'] ? 'show-name' : null; ?>
			required="<?php echo false === $attributes['required'] ? 'false' : 'true'; ?>"
			default-country="<?php echo esc_attr( $default_country ); ?>"
			name-placeholder="<?php echo esc_attr( $attributes['name_placeholder'] ); ?>"
			country-placeholder="<?php echo esc_attr( $attributes['country_placeholder'] ); ?>"
			city-placeholder="<?php echo esc_attr( $attributes['city_placeholder'] ); ?>"
			line-1-placeholder="<?php echo esc_attr( $attributes['line_1_placeholder'] ); ?>"
			line-2-placeholder="<?php echo esc_attr( $attributes['line_2_placeholder'] ); ?>"
			postal-code-placeholder="<?php echo esc_attr( $attributes['postal_code_placeholder'] ); ?>"
			state-placeholder="<?php echo esc_attr( $attributes['state_placeholder'] ); ?>"
		></sc-order-shipping-address>
		<?php

		if ( $attributes['collect_billing'] ) {
			?>
			<sc-order-billing-address
			label="<?php echo esc_attr( $attributes['billing_label'] ); ?>"
			<?php echo $attributes['show_name'] ? 'show-name' : null; ?>
			default-country="<?php echo esc_attr( $default_country ); ?>"
			name-placeholder="<?php echo esc_attr( $attributes['name_placeholder'] ); ?>"
			country-placeholder="<?php echo esc_attr( $attributes['country_placeholder'] ); ?>"
			city-placeholder="<?php echo esc_attr( $attributes['city_placeholder'] ); ?>"
			line-1-placeholder="<?php echo esc_attr( $attributes['line_1_placeholder'] ); ?>"
			line-2-placeholder="<?php echo esc_attr( $attributes['line_2_placeholder'] ); ?>"
			postal-code-placeholder="<?php echo esc_attr( $attributes['postal_code_placeholder'] ); ?>"
			state-placeholder="<?php echo esc_attr( $attributes['state_placeholder'] ); ?>"
			toggle-label="<?php echo esc_attr( $attributes['billing_toggle_label'] ); ?>"
		></sc-order-billing-address>
			<?php
		}

		return ob_get_clean();
	}
}
