<div
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'style' => $style,
			)
		)
	); ?>
>
	<div
		class="wp-block-surecart-slide-out-cart-header__close"
		data-wp-on--click="surecart/cart::actions.toggle"
		role="button"
		tabindex="0"
		aria-label="<?php esc_attr_e( 'Close cart', 'surecart' ); ?>"
	>
		<?php echo wp_kses( SureCart::svg()->get( 'arrow-right' ), sc_allowed_svg_html() ); ?>
	</div>

	<span class="wp-block-surecart-slide-out-cart-header__title" inert>
		<?php echo wp_kses_post( $attributes['text'] ); ?>
	</span>

	<div class="sc-tag sc-tag--default">
		<span data-wp-text="state.itemsCount"></span>
	</div>
</div>
