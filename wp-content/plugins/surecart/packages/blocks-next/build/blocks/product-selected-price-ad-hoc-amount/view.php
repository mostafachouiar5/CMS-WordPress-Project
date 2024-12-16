<div
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'style'            => 'width:' . esc_attr( $attributes['width'] ) . ';',
				'data-sc-block-id' => 'custom-amount',
			)
		)
	); ?>
	data-wp-bind--hidden="!context.selectedPrice.ad_hoc"
	hidden
>
	<label for="sc-product-custom-amount" class="sc-form-label">
		<?php echo wp_kses_post( $attributes['label'] ?? esc_html_e( 'Amount', 'surecart' ) ); ?>
	</label>

	<div class="sc-input-group">
		<span class="sc-input-group-text" id="basic-addon1" data-wp-text="context.selectedPrice.currency_symbol"></span>

		<input
			class="sc-form-control"
			id="sc-product-custom-amount"
			type="number"
			step="0.01"
			data-wp-bind--value="context.adHocAmount"
			data-wp-on--input="callbacks.setAdHocAmount"
			data-wp-bind--min="context.selectedPrice.converted_ad_hoc_min_amount"
			data-wp-bind--max="context.selectedPrice.converted_ad_hoc_max_amount"
			data-wp-bind--required="context.selectedPrice.ad_hoc"
		/>
	</div>
</div>
