<span
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	aria-label="<?php echo esc_html( $price->interval_text ); ?>"
>
	<?php echo esc_html( $price->short_interval_text . $price->short_interval_count_text ); ?>
</span>
