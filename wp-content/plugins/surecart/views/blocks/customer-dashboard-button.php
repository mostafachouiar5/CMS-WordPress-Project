<sc-button href="<?php echo esc_url( $href ); ?>" type="<?php echo esc_attr( $type ); ?>" size="<?php echo esc_attr( $size ); ?>">
	<?php if ( ! empty( $show_icon ) ) : ?>
		<sc-icon name="shopping-bag" style="font-size: 18px"></sc-icon>
	<?php endif; ?>
	<?php echo esc_html( $label ); ?>
</sc-button>
