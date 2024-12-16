<div class="wp-block-button">
	<a
		class="<?php echo esc_attr( $class ); ?>"
		href="<?php echo esc_url( $href ); ?>"
		style="<?php echo esc_attr( $style ); ?>"
	>
		<span class="sc-button__link-text">
			<?php echo wp_kses_post( $label ); ?>
		</span>
	</a>
</div>