<?php

namespace SureCartBlocks\Blocks\CustomerDashboardButton;

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
		$href = \SureCart::pages()->url( 'dashboard' );

		$label = $attributes['label'] ?? '';

		if ( empty( $label ) ) {
			$label = $content;
		}
		ob_start(); ?>

		<div>
		<sc-button href="<?php echo esc_url( $href ); ?>" type="<?php echo esc_attr( $attributes['type'] ?? 'primary' ); ?>" size="<?php echo esc_attr( $attributes['size'] ?? 'medium' ); ?>" <?php echo esc_attr( ! empty( $attributes['full'] ) ? 'full' : '' ); ?>>
				<?php if ( ! empty( $attributes['show_icon'] ) ) : ?>
					<sc-icon name="user" style="font-size: 18px" slot="prefix"></sc-icon>
				<?php endif; ?>
				<?php echo esc_html( ! empty( $label ) ? $label : __( 'Dashboard', 'surecart' ) ); ?>
			</sc-button>
		</div>

		<?php
		return ob_get_clean();
	}
}
