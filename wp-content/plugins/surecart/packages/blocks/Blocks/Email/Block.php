<?php

namespace SureCartBlocks\Blocks\Email;

use SureCartBlocks\Blocks\BaseBlock;
/**
 * Logout Button Block.
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
		$tracking_confirmation = \SureCart::settings()->get( 'tracking_confirmation', false );
		if ( $tracking_confirmation ) {
			$tracking_confirmation_message = \SureCart::settings()->get( 'tracking_confirmation_message', esc_html__( 'Your email and cart are saved so we can send email reminders about this order.', 'surecart' ) );
		}
		ob_start(); ?>

		<sc-customer-email
			class="<?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
			label="<?php echo esc_attr( $attributes['label'] ?? '' ); ?>"
			<?php echo ! empty( $attributes['placeholder'] ) ? 'placeholder="' . esc_attr( $attributes['placeholder'] ) . '"' : false; ?>
			<?php echo ! empty( $attributes['help'] ) ? 'help="' . esc_attr( $attributes['help'] ) . '"' : false; ?>
			<?php echo ! empty( $attributes['autofocus'] ) ? 'autofocus' : false; ?>
			<?php echo ! empty( $tracking_confirmation_message ) ? 'tracking-confirmation-message="' . esc_attr( $tracking_confirmation_message ) . '"' : false; ?>
			required
			autocomplete='email'
			inputmode='email'
		>
		</sc-customer-email>

		<?php
		return ob_get_clean();
	}
}
