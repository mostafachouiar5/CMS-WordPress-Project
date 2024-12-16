<div
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'style' => $style,
			)
		)
	); ?>
	data-wp-bind--hidden="!state.checkout.bump_amount"
	hidden
>
	<div class="sc-product-line-item">
		<div class="sc-product-line-item__item">
			<div class="sc-product-line-item__text">
				<div class="sc-product-line-item__text-details">
					<div class="sc-bump-line-item__description">
						<span>
							<?php echo wp_kses_post( $attributes['label'] ?? __( 'Bundle Discount', 'surecart' ) ); ?>
						</span>
					</div>
				</div>
			</div>

			<div class="sc-product-line-item__suffix">
				<div class="sc-bump-line-item__price">
					<div class="price">
						<span data-wp-text="state.checkout.bump_display_amount"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
