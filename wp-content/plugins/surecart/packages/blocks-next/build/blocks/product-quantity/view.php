<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<label for="sc-quantity" class="sc-form-label">
		<?php echo wp_kses_post( $attributes['label'] ?? esc_html_e( 'Quantity', 'surecart' ) ); ?>
	</label>
	<div
		class="sc-input-group sc-quantity-selector"
		data-wp-class--quantity--disabled="state.isQuantityDisabled"
		style="<?php echo esc_attr( $styles['css'] ?? '' ); ?>"
	>
		<div
			class="sc-input-group-text sc-quantity-selector__decrease"
			role="button"
			tabindex="0"
			data-wp-on--click="callbacks.onQuantityDecrease"
			data-wp-bind--disabled="state.isQuantityDecreaseDisabled"
			data-wp-bind--aria-disabled="state.isQuantityDecreaseDisabled"
			data-wp-class--button--disabled="state.isQuantityDecreaseDisabled"
			aria-label="<?php echo esc_html__( 'Decrease quantity by one.', 'surecart' ); ?>"
			data-wp-on--keydown="callbacks.onQuantityDecrease"
		>
			<?php echo wp_kses( SureCart::svg()->get( 'minus' ), sc_allowed_svg_html() ); ?>
		</div>
		<input
			id="sc-quantity"
			type="number"
			class="sc-form-control sc-quantity-selector__control"
			data-wp-bind--value="context.quantity"
			data-wp-on--change="callbacks.onQuantityChange"
			data-wp-bind--disabled="state.isQuantityDisabled"
			data-wp-bind--aria-disabled="state.isQuantityDisabled"
			min="1"
			step="1"
			autocomplete="off"
			role="spinbutton"
		/>
		<div
			class="sc-input-group-text sc-quantity-selector__increase"
			role="button"
			tabindex="0"
			data-wp-on--click="callbacks.onQuantityIncrease"
			data-wp-bind--disabled="state.isQuantityIncreaseDisabled"
			data-wp-bind--aria-disabled="state.isQuantityIncreaseDisabled"
			data-wp-class--button--disabled="state.isQuantityIncreaseDisabled"
			aria-label="<?php echo esc_html__( 'Increase quantity by one.', 'surecart' ); ?>"
			data-wp-on--keydown="callbacks.onQuantityIncrease"
		>
			<?php echo wp_kses( SureCart::svg()->get( 'plus' ), sc_allowed_svg_html() ); ?>
		</div>
	</div>
</div>
