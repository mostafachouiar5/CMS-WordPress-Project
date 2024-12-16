<form
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			[
				'data-sc-block-id' => 'product-page',
			]
		)
	); ?>
	<?php
	echo wp_kses_data( wp_interactivity_data_wp_context( $context ) );
	?>
	data-wp-interactive='{ "namespace": "surecart/product-page" }'
	data-wp-on--submit="callbacks.handleSubmit"
	data-wp-init="callbacks.init"
>
	<?php echo do_blocks( $content );  // phpcs:ignore WordPress.Security.EscapeOutput ?>
</form>
