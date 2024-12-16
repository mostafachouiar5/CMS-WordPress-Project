<?php $html_tag = 'h' . (int) ( ! empty( $attributes['level'] ) ? $attributes['level'] : 3 ); ?>
<<?php echo esc_html( $html_tag ); ?> <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'aria-label' => get_the_title() ] ) ); ?>>
	<?php if ( $is_link ) : ?>
		<a
			href="<?php echo esc_url( get_the_permalink() ); ?>"
			title="<?php echo esc_attr( the_title_attribute( [ 'echo' => false ] ) ); ?>"
			target="<?php echo esc_attr( $attributes['linkTarget'] ); ?>"
			<?php echo ! empty( $rel ) ? 'rel="' . esc_attr( $rel ) . '"' : ''; ?>
		>
	<?php endif; ?>

	<?php the_title(); ?>

	<?php if ( $is_link ) : ?>
		</a>
	<?php endif; ?>
</<?php echo esc_html( $html_tag ); ?>>
