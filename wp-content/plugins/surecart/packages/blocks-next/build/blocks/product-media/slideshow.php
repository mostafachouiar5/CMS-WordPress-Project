<div
	class="sc-image-slider"
	data-wp-interactive='{ "namespace": "surecart/image-slider" }'
	data-wp-init="actions.init"
	data-wp-watch="actions.updateSlider"
	<?php echo wp_kses_data( wp_interactivity_data_wp_context( $slider_options ) ); ?>
>
	<div class="swiper" style="height: <?php echo esc_attr( $height ); ?>">
		<div class="swiper-wrapper">
			<?php foreach ( $gallery as $index => $image ) : ?>
				<div
					data-wp-interactive='{ "namespace": "surecart/product-page" }'
					data-wp-key="<?php echo esc_attr( $image->id ); ?>"
					data-wp-class--swiper-slide="state.shouldDisplayImage"
					data-wp-style--display="state.imageDisplay"
					<?php
					echo wp_kses_data(
						wp_interactivity_data_wp_context(
							[
								'optionValue' => $image->variant_option,
							]
						)
					);
					?>
				>
					<div class="swiper-zoom-container" data-swiper-zoom="5">
						<?php
							echo wp_kses_post(
								$image->html(
									'large',
									array_filter(
										[
											'loading' => $index > 0 ? 'lazy' : 'eager',
											'style'   => ( ! empty( $width ) ? 'max-width:' . esc_attr( $width ) : '' ) . ';' . ( empty( $attributes['auto_height'] ) && ! empty( $attributes['height'] ) ? "height: {$attributes['height']}" : '' ),
										]
									)
								)
							);
						?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>

	<?php if ( ! empty( $attributes['show_thumbs'] ) ) : ?>
		<div class="sc-image-slider__thumbs">
			<div class="sc-image-slider-button__prev" tabindex="-1" role="button" aria-label="<?php esc_attr_e( 'Previous Page', 'surecart' ); ?>">
				<?php echo wp_kses( SureCart::svg()->get( 'chevron-left' ), sc_allowed_svg_html() ); ?>
			</div>

			<div class="swiper">
				<div class="swiper-wrapper <?php echo esc_attr( 'sc-has-' . $attributes['thumbnails_per_page'] . '-thumbs' ); ?>">
					<?php foreach ( $gallery as $thumb_index => $image ) : ?>
						<div
							data-wp-interactive='{ "namespace": "surecart/product-page" }'
							data-wp-key="<?php echo esc_attr( $image->id ); ?>"
							data-wp-class--swiper-slide="state.shouldDisplayImage"
							data-wp-style--display="state.imageDisplay"
							<?php
							echo wp_kses_data(
								wp_interactivity_data_wp_context(
									[
										'optionValue' => $image->variant_option,
									]
								)
							);
							?>
						>
							<?php
							echo wp_kses_post(
								$image->html(
									'thumbnail',
									array(
										'loading' => $thumb_index > $attributes['thumbnails_per_page'] ? 'lazy' : 'eager',
									)
								)
							);
							?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="sc-image-slider-button__next" tabindex="-1" role="button" aria-label="<?php esc_attr_e( 'Next Page', 'surecart' ); ?>">
				<?php echo wp_kses( SureCart::svg()->get( 'chevron-right' ), sc_allowed_svg_html() ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
