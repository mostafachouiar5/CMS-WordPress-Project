<figure <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php
	echo wp_kses_post(
		$featured_image->html(
			'large',
			array(
				'loading' => 'eager',
				'style'   => ! empty( $width ) ? 'max-width:' . esc_attr( $width ) : '',
			)
		)
	);
	?>
</figure>
