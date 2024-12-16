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
			<?php echo ! empty( $attributes['rel'] ) ? 'rel="' . esc_attr( $attributes['rel'] ) . '"' : ''; ?>
		>
	<?php endif; ?>
		<img src="<?php echo esc_url( \SureCart::core()->assets()->getUrl() . '/images/placeholder.jpg' ); ?>"
			alt="<?php echo esc_attr( the_title_attribute( [ 'echo' => false ] ) ); ?>"
			width="1180"
			height="1180"/>
	<?php if ( $is_link ) : ?>
		</a>
	<?php endif; ?>
</figure>
