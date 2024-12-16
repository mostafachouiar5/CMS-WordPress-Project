<sc-tab
	href="<?php echo esc_url( $href ); ?>"
	active="<?php echo esc_attr( $active ); ?>"
	slot="nav"
>
	<?php if ( ! empty( $icon ) ) : ?>
		<sc-icon style="font-size: 18px;" name="<?php echo esc_attr( $icon ); ?>" slot="prefix"></sc-icon>
	<?php endif; ?>
	<?php echo esc_attr( $title ?? 'Tab' ); ?>
</sc-tab>
