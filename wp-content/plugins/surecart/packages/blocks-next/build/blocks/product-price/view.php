<?php $product = sc_get_product(); ?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php echo ! empty( $attributes['show_range'] ) ? esc_html( $product->range_display_amount ?? '' ) : esc_html( $product->display_amount ?? '' ); ?>
</div>
