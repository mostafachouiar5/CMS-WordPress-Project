<?php

namespace SureCartBlocks\Blocks\CollapsibleRow;

use SureCart\Models\Form;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Checkout block
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
		ob_start();
		?>

		<div class="wp-block-surecart-collapsible-row">
			<sc-toggle class="sc-collapsible-row" borderless>
				<span slot="summary">
					<?php if ( ! empty( $attributes['icon'] ) ) : ?>
						<sc-icon name="<?php echo esc_attr( $attributes['icon'] ); ?>" style="font-size: 18px"></sc-icon>
					<?php endif; ?>
					<span><?php echo wp_kses_post( $attributes['heading'] ?? '' ); ?></span>
				</span>
				<?php echo filter_block_content( $content, 'post' ); ?>
			</sc-toggle>
		</div>

		<?php
		return ob_get_clean();
	}
}
