<div
	<?php echo wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'style' => $style,
			)
		)
	); ?>
	<?php
		echo wp_kses_data(
			wp_interactivity_data_wp_context(
				[
					'discountInputOpen' => false,
				]
			)
		);
		?>
	data-wp-on-document--click="surecart/checkout::actions.closeCouponOnClickOutside"
>
	<!-- Discount applied Applied coupon UI -->
	<div
		class="sc-line-item__item sc-coupon-form"
		data-wp-bind--hidden="!state.isDiscountApplied"
		hidden
	>
		<div class="sc-line-item__text">
			<div class="sc-line-item__description">
				<?php esc_html_e( 'Discount', 'surecart' ); ?>
				<div
					class="sc-tag"
					data-wp-class--sc-tag--success="state.discountIsRedeemable"
					data-wp-class--sc-tag--warning="!state.discountIsRedeemable"
				>
					<span data-wp-text="state.checkout.discount.promotion.code"></span>
					<button
						data-wp-on--click="actions.removeDiscount"
						id="sc-coupon-remove-discount"
						title="<?php esc_attr_e( 'Delete discount', 'surecart' ); ?>"
					>
						<?php echo wp_kses( SureCart::svg()->get( 'x', [ 'class' => '' ] ), sc_allowed_svg_html() ); ?>
					</button>
				</div>
			</div>
		</div>

		<div class="sc-line-item__end">
			<div class="sc-line-item__price-text">
				<!-- redeemable UI -->
				<div class="sc-line-item__price-description" data-wp-bind--hidden="!state.discountIsRedeemable">
					<span
						class="coupon-human-discount"
						data-wp-text="state.checkout.human_discount_with_duration"
					></span>
				</div>
				<div class="sc-line-item__price" data-wp-bind--hidden="!state.discountIsRedeemable" data-wp-text="state.checkout.discount_display_amount"></div>

				<!-- non-redeemable UI -->
				<div class="sc-line-item__price-description" data-wp-bind--hidden="state.discountIsRedeemable">
					<div class="sc-coupon__status">
						<?php echo wp_kses( SureCart::svg()->get( 'alert-triangle', [ 'class' => '' ] ), sc_allowed_svg_html() ); ?>
						<span data-wp-text="state.checkout.discount.redeemable_display_status"></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Discount Button and Form UI -->
	<div
		class="sc-coupon-form"
		data-wp-bind--hidden="state.isDiscountApplied"
	>
		<?php if ( $attributes['collapsed'] ) : ?>
			<div>
				<div
					data-wp-bind--hidden="context.discountInputOpen"
					hidden
					class="trigger"
					data-wp-on--click="surecart/checkout::actions.toggleDiscountInput"
					data-wp-on--keydown="surecart/checkout::actions.toggleDiscountInput"
					aria-role="button"
					tabindex="0"
					id="sc-coupon-trigger"
				>
					<?php echo esc_attr( $attributes['text'] ); ?>
				</div>

				<form>
					<div
						data-wp-bind--hidden="!context.discountInputOpen"
						hidden
						class="sc-input-group sc-coupon-form__input-group"
					>
						<input
							type="text"
							id="coupon"
							class="sc-form-control sc-coupon-form__input"
							aria-label="<?php esc_attr_e( 'Coupon code', 'surecart' ); ?>"
							aria-describedby="coupon-input-addon"
							placeholder="<?php echo isset( $attributes['placeholder'] ) ? esc_attr( $attributes['placeholder'] ) : esc_html__( 'Enter coupon code', 'surecart' ); ?>"
							data-wp-bind--value="state.promotionCode"
							data-wp-on--keydown="surecart/checkout::actions.maybeApplyDiscountOnKeyChange"
							data-wp-on--keyup="surecart/checkout::actions.maybeApplyDiscountOnKeyChange"
						>
						<span class="sc-input-group-text" id="coupon-input-addon">
							<button
								type="submit"
								data-wp-bind--hidden="!state.promotionCode"
								data-wp-on--click="actions.applyDiscount"
							>
								<?php echo isset( $attributes['button_text'] ) ? esc_attr( $attributes['button_text'] ) : esc_html__( 'Apply', 'surecart' ); ?>
							</button>
						</span>
					</div>
				</form>
			</div>
		<?php else : ?>
			<div
			>
				<label class="sc-coupon-input-label" for="sc-coupon-input" style="color: <?php echo ! empty( $attributes['textColor'] ) ? esc_attr( $attributes['textColor'] ) : 'var(--sc-input-label-color)'; ?>">
					<?php echo esc_html( $attributes['text'] ); ?>
				</label>

				<div class="sc-input-group sc-coupon-form__input-group">
					<input
						type="text"
						id="sc-coupon-input"
						class="sc-form-control sc-coupon-form__input"
						aria-label="<?php esc_attr_e( 'Coupon code', 'surecart' ); ?>"
						aria-describedby="sc-coupon-trigger"
						placeholder="<?php echo isset( $attributes['placeholder'] ) ? esc_attr( $attributes['placeholder'] ) : esc_html__( 'Enter coupon code', 'surecart' ); ?>"
						data-wp-bind="state.discountCode"
						data-wp-on--keydown="surecart/checkout::actions.maybeApplyDiscountOnKeyChange"
						data-wp-on--keyup="surecart/checkout::actions.maybeApplyDiscountOnKeyChange"
					>
					<span class="sc-input-group-text" id="sc-coupon-trigger">
						<button
							data-wp-bind--hidden="!state.promotionCode"
							data-wp-on--click="actions.applyDiscount"
						>
							<?php echo isset( $attributes['button_text'] ) ? esc_attr( $attributes['button_text'] ) : esc_html__( 'Apply', 'surecart' ); ?>
						</button>
					</span>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
