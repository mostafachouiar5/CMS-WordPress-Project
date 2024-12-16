<div <?php echo wp_kses_data(
	get_block_wrapper_attributes(
		array(
			'style' => $style,
		)
	)
); ?>>
	<div class="sc-product-line-item">
		<div class="sc-product-line-item__item">
			<div class="sc-product-line-item__text">
				<div class="sc-product-line-item__text-details">
					<div class="sc-product-line-item__title">
						<span>
							<?php echo wp_kses_post( $attributes['label'] ?? __( 'Total', 'surecart' ) ); ?>
						</span>
					</div>
				</div>
			</div>

			<div class="sc-product-line-item__suffix">
				<div class="sc-product-line-item__price">
					<div class="price">
						<span data-wp-text="state.checkout.subtotal_display_amount" data-wp-bind--hidden="state.isDiscountApplied"></span>
						<span data-wp-text="state.checkout.total_display_amount" data-wp-bind--hidden="!state.isDiscountApplied"></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div
		class="sc-product-line-item"
		data-wp-bind--hidden="!state.checkout.is_installment"
	>
		<div class="sc-product-line-item__item">
			<div class="sc-product-line-item__text">
				<div class="sc-product-line-item__text-details">
					<div class="sc-product-line-item__description">
						<?php esc_html_e( 'Total Installment Payments', 'surecart' ); ?>
					</div>
				</div>
			</div>

			<div class="sc-product-line-item__suffix">
				<div class="sc-product-line-item__price">
					<div class="price">
						<span data-wp-text="state.checkout.full_display_amount"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
