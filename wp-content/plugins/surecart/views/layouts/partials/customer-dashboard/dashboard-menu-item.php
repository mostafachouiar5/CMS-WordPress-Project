<?php echo ! empty( $is_mobile ) ? '<sc-menu-item href="' . esc_url( $href ?? '' ) . '" role="option">' : '<sc-tab aria-label="' . esc_html( $name ) . '" href="' . esc_url( $href ?? '' ) . '" ' . ( ! empty( $active ) ? 'active' : '' ) . '>'; ?>
	<sc-icon aria-hidden="true" style="opacity: 0.65; font-size: 18px;" name="<?php echo esc_attr( $icon_name ); ?>" slot="prefix"></sc-icon>
	<?php echo esc_html( $name ); ?>
<?php echo ! empty( $is_mobile ) ? '</sc-menu-item>' : '</sc-tab>'; ?>
