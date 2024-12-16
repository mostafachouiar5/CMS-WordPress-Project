<figure
<?php
echo wp_kses_data(
	get_block_wrapper_attributes(
		array(
			'class' => $class,
			'style' => $style,
		)
	)
);
?>
>
	<?php if ( $is_link ) : ?>
		<a
			href="<?php echo esc_url( get_the_permalink() ); ?>"
			title="<?php echo esc_attr( the_title_attribute( [ 'echo' => false ] ) ); ?>"
			target="<?php echo esc_attr( $attributes['linkTarget'] ); ?>"
			<?php echo ! empty( $rel ) ? 'rel="' . esc_attr( $rel ) . '"' : ''; ?>
		>
	<?php endif; ?>
		<?php echo wp_kses( $product_image_html, sc_allowed_image_html() ); ?>
	<?php if ( $is_link ) : ?>
		</a>
	<?php endif; ?>
</figure>
