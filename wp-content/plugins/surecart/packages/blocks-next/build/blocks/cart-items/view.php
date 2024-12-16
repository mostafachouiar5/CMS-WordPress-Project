<div
	class="wp-block-surecart-cart-items__wrapper"
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'style' => $style,
			)
		)
	); ?>
	role="list"
>
	<template
		data-wp-each--line_item="state.checkoutLineItems"
		data-wp-each-key="context.line_item.id"
	>
		<div class="sc-product-line-item" role="listitem">
			<div class="sc-product-line-item__item">
				<img
					class="sc-product-line-item__image"
					data-wp-bind--hidden="!context.line_item.image.src"
					data-wp-bind--src="context.line_item.image.src"
					data-wp-bind--alt="context.line_item.image.alt"
					data-wp-bind--srcset="context.line_item.image.srcset"
					data-wp-bind--sizes="context.line_item.image.sizes"
					loading="lazy"
					alt=""
				/>

				<div class="sc-product-line-item__text">
					<div class="sc-product-line-item__text-details">
						<a data-wp-bind--href="state.lineItemPermalink" class="sc-product-line-item__title">
							<span data-wp-text="context.line_item.price.product.name"></span>
						</a>
						<div class="sc-product-line-item__description sc-product-line-item__price-variant">
							<div data-wp-text="state.lineItemVariant"></div>
							<div data-wp-text="context.line_item.price.name"></div>
						</div>
						<?php if ( ! $attributes['editable'] ) : ?>
							<span class="sc-product-line-item__description">
								<?php esc_html_e( 'Qty:', 'surecart' ); ?>
								<span data-wp-text="context.line_item.quantity"></span>
							</span>
						<?php elseif ( $attributes['editable'] ) : ?>
							<div
								class="sc-input-group sc-input-group-sm sc-quantity-selector"
								data-wp-class--quantity--disabled="state.isQuantityDisabled"
								data-wp-bind--hidden="!state.isEditable"
								hidden
							>
								<div
									class="sc-input-group-text sc-quantity-selector__decrease"
									role="button"
									tabindex="0"
									data-wp-on--click="surecart/checkout::actions.onQuantityDecrease"
									data-wp-on--keydown="surecart/checkout::actions.onQuantityDecrease"
									data-wp-bind--disabled="state.isQuantityDecreaseDisabled"
									data-wp-bind--aria-disabled="state.isQuantityDecreaseDisabled"
									data-wp-class--button--disabled="state.isQuantityDecreaseDisabled"
									aria-label="<?php echo esc_html__( 'Decrease quantity by one.', 'surecart' ); ?>"
								>
									<?php echo wp_kses( SureCart::svg()->get( 'minus' ), sc_allowed_svg_html() ); ?>
								</div>
								<input
									type="number"
									class="sc-form-control sc-quantity-selector__control"
									data-wp-bind--value="context.line_item.quantity"
									data-wp-on--change="surecart/checkout::actions.onQuantityChange"
									data-wp-bind--min="context.line_item.min"
									data-wp-bind--aria-valuemin="context.line_item.min"
									data-wp-bind--max="context.line_item.max"
									data-wp-bind--aria-valuemax="context.line_item.max"
									data-wp-bind--disabled="surecart/checkout::state.loading"
									step="1"
									autocomplete="off"
									role="spinbutton"
								/>
								<div
									class="sc-input-group-text sc-quantity-selector__increase"
									role="button"
									tabindex="0"
									data-wp-on--click="surecart/checkout::actions.onQuantityIncrease"
									data-wp-on--keydown="surecart/checkout::actions.onQuantityIncrease"
									data-wp-bind--disabled="state.isQuantityIncreaseDisabled"
									data-wp-bind--aria-disabled="state.isQuantityIncreaseDisabled"
									data-wp-class--button--disabled="state.isQuantityIncreaseDisabled"
									aria-label="<?php echo esc_html__( 'Increase quantity by one.', 'surecart' ); ?>"
								>
									<?php echo wp_kses( SureCart::svg()->get( 'plus' ), sc_allowed_svg_html() ); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="sc-product-line-item__suffix">
					<?php if ( $attributes['removable'] ) : ?>
						<button
							class="sc-product-line-item__remove-button"
							aria-label="<?php esc_attr_e( 'Remove item', 'surecart' ); ?>"
							data-wp-on--click="surecart/checkout::actions.removeLineItem"
						>
							<?php echo wp_kses( SureCart::svg()->get( 'x', [ 'class' => 'sc-product-line-item__remove' ] ), sc_allowed_svg_html() ); ?>
						</button>
					<?php endif; ?>

					<div class="sc-product-line-item__price">
						<div class="sc-product-line-item__price-amount">
							<span>
								<span
									data-wp-bind--hidden="!state.lineItemHasScratchAmount"
									data-wp-text="context.line_item.price.scratchAmount"
								></span>
								<span data-wp-text="context.line_item.subtotal_display_amount"></span>
							</span>

							<span
								class="sc-product-line-item__price-description"
								data-wp-bind--hidden="!context.line_item.price.short_interval_text"
								data-wp-text="context.line_item.price.short_interval_text"
							></span>

							<span
								class="sc-product-line-item__price-description"
								data-wp-bind--hidden="!context.line_item.price.short_interval_count_text"
								data-wp-text="context.line_item.price.short_interval_count_text"
							></span>
						</div>

						<div
							class="sc-product-line-item__trial sc-product-line-item__price-description"
							data-wp-bind--hidden="!context.line_item.price.trial_text"
							data-wp-text="context.line_item.price.trial_text"
						></div>

						<div
							class="sc-product-line-item__setup-fee sc-product-line-item__price-description"
							data-wp-bind--hidden="!context.line_item.price.setup_fee_text"
							data-wp-text="context.line_item.price.setup_fee_text"
						></div>

						<div
							class="sc-product-line-item__purchasable-status sc-product-line-item__price-description"
							data-wp-bind--hidden="!context.line_item.purchasable_status_display"
							data-wp-text="context.line_item.purchasable_status_display"
						></div>
					</div>
				</div>
			</div>
		</div>
	</template>
</div>
