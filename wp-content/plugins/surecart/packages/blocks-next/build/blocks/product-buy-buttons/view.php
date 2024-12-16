<div
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
>
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>

