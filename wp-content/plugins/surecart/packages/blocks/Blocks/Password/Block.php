<?php

namespace SureCartBlocks\Blocks\Password;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Password block
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
	public function render( $attributes, $content ) {
		ob_start(); ?>

		<sc-order-password
			type="password"
			name="password"
			class="<?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
			label="<?php echo esc_attr( $attributes['label'] ?? '' ); ?>"
			help="<?php echo esc_attr( $attributes['help'] ?? '' ); ?>"
			autofocus="<?php echo esc_attr( $attributes['autofocus'] ?? false ); ?>"
			maxlength="<?php echo esc_attr( $attributes['maxlength'] ?? '' ); ?>"
			minlength="<?php echo esc_attr( $attributes['minlength'] ?? '' ); ?>"
			placeholder="<?php echo esc_attr( $attributes['placeholder'] ?? '' ); ?>"
			showLabel="<?php echo esc_attr( $attributes['showLabel'] ?? true ); ?>"
			size="<?php echo esc_attr( $attributes['size'] ?? 'medium' ); ?>"
			value="<?php echo esc_attr( $attributes['value'] ?? '' ); ?>"
			required="<?php echo esc_attr( ! empty( $attributes['required'] ) ? 'true' : 'false' ); ?>"
			confirmation="<?php echo esc_attr( $attributes['confirmation'] ? 'true' : 'false' ); ?>"
			confirmation-label="<?php echo esc_attr( $attributes['confirmation_label'] ?? '' ); ?>"
			confirmation-placeholder="<?php echo esc_attr( $attributes['confirmation_placeholder'] ?? '' ); ?>"
			confirmation-help="<?php echo esc_attr( $attributes['confirmation_help'] ?? '' ); ?>"
			enable-validation="<?php echo get_option( 'surecart_password_validation_enabled', true ) ? 'true' : 'false'; ?>"
		>
		</sc-order-password>

		<?php
		return ob_get_clean();
	}
}
