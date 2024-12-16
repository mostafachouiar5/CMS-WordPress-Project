<figure <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<img
		src="<?php echo esc_url( trailingslashit( \SureCart::core()->assets()->getUrl() ) . 'images/placeholder.jpg' ); ?>"
		style="<?php echo ! empty( $width ) ? 'max-width:' . esc_attr( $width ) : ''; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"
	/>
</figure>
