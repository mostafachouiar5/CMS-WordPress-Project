<div
	data-wp-interactive='{ "namespace": "surecart/checkout" }'
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	<?php
	echo wp_kses_data(
		wp_interactivity_data_wp_context(
			[
				'formId' => intval( $form->ID ),
				'mode'   => esc_attr( $form_mode ),
			]
		)
	);
	?>
	data-wp-on--click="surecart/cart::actions.toggle"
	data-wp-on--keydown="surecart/cart::actions.toggle"
	tabindex="0"
	role="button"
	data-wp-bind--hidden="!state.hasItems"
	hidden
>
	<div class="wp-block-surecart-cart-icon__container">
		<div class="wp-block-surecart-cart-icon__icon" aria-label="<?php esc_attr_e( 'Cart Button.', 'surecart' ); ?>">
			<?php echo wp_kses( SureCart::svg()->get( $icon, [ 'class' => '' ] ), sc_allowed_svg_html() ); ?>
		</div>

		<span
			class="wp-block-surecart-cart-icon__count"
			data-wp-text="state.itemsCount"
			data-wp-bind--aria-label="state.itemsCountAriaLabel"
		>
		</span>
	</div>
</div>
