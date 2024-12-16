<div
	class="sc-cart-submit__wrapper wp-block-buttons"
	style="<?php echo esc_attr( $wrapper_style ); ?>"
>
	<div class="wp-block-button">
		<a
		<?php
			echo wp_kses_data(
				get_block_wrapper_attributes(
					array(
						'class' => 'wp-block-button__link wp-element-button sc-button__link ' . ( $styles['classnames'] ?? '' ),
						'style' => $styles['css'] ?? '',
					)
				)
			);
			?>
			href="<?php echo esc_attr( \SureCart::pages()->url( 'checkout' ) ); ?>"
			class="wp-block-button__link wp-element-button sc-button__link"
			data-wp-bind--disabled="state.loading"
			data-wp-class--sc-button__link--busy="state.loading"
		>
			<span class="sc-spinner" aria-hidden="false"></span>
			<span class="sc-button__link-text"><?php echo wp_kses_post( $attributes['text'] ); ?></span>
		</a>
	</div>
</div>
