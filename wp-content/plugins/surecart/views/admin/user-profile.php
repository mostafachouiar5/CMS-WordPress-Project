<h2><?php esc_html_e( 'SureCart', 'surecart' ); ?></h2>

<table class="form-table">
	<tr>
		<th><?php esc_html_e( 'Customer', 'surecart' ); ?></th>

		<?php if ( ! empty( $test_customer ) ) : ?>
			<?php if ( is_wp_error( $test_customer ) ) : ?>
				<td>
					<?php echo wp_kses_post( $test_customer->get_error_message() ); ?> (<?php esc_html_e( 'Test', 'surecart' ); ?>)
				</td>
			<?php else : ?>
				<td>
					<a href="<?php echo esc_url( $edit_test_link ); ?>">
						<?php echo wp_kses_post( $test_customer->name ?? $test_customer->email ); ?>
					</a>

					(<?php esc_html_e( 'Test', 'surecart' ); ?>)
				</td>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! empty( $live_customer ) ) : ?>
			<?php if ( is_wp_error( $test_customer ) ) : ?>
				<td>
					<?php echo wp_kses_post( $test_customer->get_error_message() ); ?>
				</td>
			<?php else : ?>
				<td>
					<a href="<?php echo esc_url( $edit_live_link ); ?>">
						<?php echo wp_kses_post( $live_customer->name ?? $live_customer->email ); ?>
					</a>
				</td>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( empty( $live_customer ) && empty( $test_customer ) ) : ?>
			<?php esc_html_e( 'This user is not a customer.', 'surecart' ); ?>
		<?php endif; ?>
	</tr>
</table>
