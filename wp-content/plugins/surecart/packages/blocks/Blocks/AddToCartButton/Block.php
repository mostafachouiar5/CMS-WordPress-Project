<?php

namespace SureCartBlocks\Blocks\AddToCartButton;

use SureCart\Models\Blocks\ProductPageBlock;
use SureCart\Models\Price;

/**
 * AddToCart Button Block.
 */
class Block extends \SureCartBlocks\Blocks\BuyButton\Block {
	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content = '' ) {
		// need a price id.
		if ( empty( $attributes['price_id'] ) ) {
			return '';
		}

		$price = Price::with( [ 'product', 'product.variants' ] )->find( $attributes['price_id'] );
		if ( empty( $price->id ) ) {
			return '';
		}

		// get the product.
		$product = $price->product;

		// setup the postdata.
		global $post;
		$post = $product->post;  // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited,
		setup_postdata( $post );

		$variants = ! empty( $attributes['variant_id'] ) ? array_filter(
			$product->variants->data ?? [],
			function ( $variant ) use ( $attributes ) {
				return $variant->id == $attributes['variant_id'];
			}
		) : null;
		$variant  = $variants ? array_shift( $variants ) : null;

		$form = \SureCart::forms()->getDefault();
		if ( empty( $form->ID ) ) {
			return '';
		}

		// Use backgroundColor and textColor if exist.
		$styles = '';
		if ( ! empty( $attributes['backgroundColor'] ) ) {
			$styles .= "background-color: {$attributes['backgroundColor']}; ";
		}
		if ( ! empty( $attributes['textColor'] ) ) {
			$styles .= "color: {$attributes['textColor']}; ";
		}

		$class = 'sc-button wp-element-button wp-block-button__link sc-button__link';

		// Slide-out is disabled, go directly to checkout.
		if ( (bool) get_option( 'sc_slide_out_cart_disabled', false ) ) {
			return \SureCart::block()->render(
				'blocks/buy-button',
				[
					'type'  => $attributes['type'] ?? 'primary',
					'size'  => $attributes['size'] ?? 'medium',
					'style' => $styles,
					'class' => $class,
					'href'  => $this->href(
						[
							[
								'id'         => $price->id,
								'variant_id' => $attributes['variant_id'] ?? null,
								'quantity'   => 1,
							],
						]
					),
					'label' => $attributes['button_text'] ?? __( 'Buy Now', 'surecart' ),
				]
			);
		}

		$controller = new ProductPageBlock();

		$price_attributes = [
			'id',
			'archived',
			'amount',
			'display_amount',
			'scratch_amount',
			'scratch_display_amount',
			'ad_hoc',
			'is_zero_decimal',
			'currency_symbol',
			'converted_ad_hoc_min_amount',
			'converted_ad_hoc_max_amount',
			'setup_fee_text',
			'interval_text',
			'short_interval_text',
			'interval_count_text',
			'payments_text',
			'trial_text',
		];

		$context = $controller->context(
			[
				'selectedPrice' => $price ? $price->only( $price_attributes ) : null,
				'prices'        => array_map( fn( $price ) => $price->only( $price_attributes ), [ $price ] ),
				'variantValues' => $variant ? array_filter(
					[
						'option_1' => $variant->option_1 ?? null,
						'option_2' => $variant->option_2 ?? null,
						'option_3' => $variant->option_3 ?? null,
					]
				) : [],
			]
		);

		ob_start(); ?>
		<style>
			.sc-form, .sc-form-wrapper {
				display: inline-block;
			}
		</style>
		<div
			class="sc-form-wrapper"
			data-wp-interactive='{ "namespace": "surecart/product-page" }'
			<?php echo wp_kses_data( wp_interactivity_data_wp_context( $context ) ); ?>
		>
			<form class="sc-form" data-wp-on--submit="callbacks.handleSubmit">
				<?php if ( ! empty( $price->ad_hoc ) ) : ?>
					<div class="sc-form-group">
						<label for="sc-product-custom-amount" class="sc-form-label">
							<?php echo wp_kses_post( $attributes['ad_hoc_label'] ?? esc_html_e( 'Amount', 'surecart' ) ); ?>
						</label>
						<div class="sc-input-group">
							<span class="sc-input-group-text" id="basic-addon1" data-wp-text="context.selectedPrice.currency_symbol"></span>

							<input
								class="sc-form-control"
								id="sc-product-custom-amount"
								type="number"
								step="0.01"
								required
								placeholder="<?php echo esc_attr( $attributes['placeholder'] ?? '' ); ?>"
								data-wp-bind--min="context.selectedPrice.converted_ad_hoc_min_amount"
								data-wp-bind--max="context.selectedPrice.converted_ad_hoc_max_amount"
								data-wp-bind--value="context.adHocAmount"
								data-wp-on--input="callbacks.setAdHocAmount"
							/>
						</div>
						<?php if ( ! empty( $attributes['help'] ) ) : ?>
							<div class="sc-help-text">
								<?php echo wp_kses_post( $attributes['help'] ); ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div
					<?php
						echo wp_kses_data(
							get_block_wrapper_attributes(
								array(
									'class' => 'wp-block-button',
								)
							)
						);
					?>
				>
					<button
						type="submit"
						class="<?php echo esc_attr( $class ); ?>"
						data-wp-class--sc-button__link--busy="context.busy"
						style="<?php echo esc_attr( $styles ); ?>"
					>
						<span class="sc-spinner" aria-hidden="true" data-wp-bind--hidden="!context.busy" hidden></span>
						<span class="sc-button__link-text">
							<?php
							// pass content for shortcode usage.
							echo wp_kses_post( ! empty( $content ) ? $content : $attributes['button_text'] );
							?>
						</span>
					</button>
				</div>
			</form>
		</div>
		<?php
		$output = ob_get_clean();
		wp_reset_postdata();
		return $output;
	}
}
