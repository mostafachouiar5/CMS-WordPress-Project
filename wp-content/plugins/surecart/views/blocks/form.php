<sc-checkout
	class="checkout"
	id="<?php echo esc_attr( $id ); ?>"
	class="<?php echo esc_attr( $classes ); ?>"
	style="<?php echo esc_attr( $style ); ?>"
	modified="<?php echo esc_attr( $modified ?? '' ); ?>"
	alignment="<?php echo esc_attr( $align ?? '' ); ?>"
	success-url="<?php echo esc_url_raw( $success_url ?? null ); ?>"
>
	<sc-form>
		<?php if ( (bool) $honeypot_enabled ?? false ) : ?>
			<sc-checkbox name="get_feedback" value="Feedback" style="display: none !important;"></sc-checkbox>
		<?php endif; ?>
		<?php echo filter_block_content( $content, 'post' ); ?>
	</sc-form>
</sc-checkout>
