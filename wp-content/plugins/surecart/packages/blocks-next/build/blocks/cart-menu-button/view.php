<a
	data-wp-interactive='{ "namespace": "surecart/checkout" }'
	<?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'menu-link' ] ) ); ?>
	<?php
	echo wp_kses_data(
		wp_interactivity_data_wp_context(
			[
				'formId'              => intval( $form->ID ),
				'mode'                => esc_attr( $form_mode ),
				'cartMenuAlwaysShown' => ! empty( $attributes['cart_menu_always_shown'] ) ? true : false,
			]
		)
	);
	?>
	data-wp-on--click="surecart/cart::actions.toggle"
	data-wp-on--keydown="surecart/cart::actions.toggle"
	tabindex="0"
>
	<div class="sc-cart-icon" aria-label="<?php esc_attr_e( 'Open cart', 'surecart' ); ?>">
		<?php echo wp_kses( $icon, sc_allowed_svg_html() ); ?>
		<span
			class="sc-cart-count"
			data-wp-text="state.itemsCount"
			data-wp-bind--hidden="!state.hasItems"
			data-wp-bind--aria-label="state.itemsCountAriaLabel"
			hidden
		></span>
	</div>
</a>
