<div
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	<?php
	echo wp_kses_data(
		wp_interactivity_data_wp_context(
			array(
				'urlPrefix' => $controller->urlParams()->getKey(),
				'products'  => $products,
			)
		)
	);
	?>
	data-wp-interactive='{ "namespace": "surecart/product-list" }'
	data-wp-router-region="<?php echo esc_attr( 'products-' . $sc_query_id ); ?>"
	data-wp-watch="callbacks.onChangeProducts"
>
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="sc-block-ui" data-wp-bind--hidden="!state.loading" hidden></div>
</div>
