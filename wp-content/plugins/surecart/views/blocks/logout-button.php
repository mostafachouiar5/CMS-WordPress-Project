<sc-button
href="<?php echo esc_url( $href ); ?>"
type="<?php echo esc_attr( $type ); ?>"
size="<?php echo esc_attr( $size ); ?>"
>
	<?php if ( ! empty( $show_icon ) ) : ?>
		<sc-icon
			slot="prefix"
			name="log-out"
		></sc-icon>
	<?php endif; ?>

	<?php echo esc_html( $label ); ?>
</sc-button>
