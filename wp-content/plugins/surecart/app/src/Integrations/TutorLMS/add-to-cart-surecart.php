<?php foreach ( $prices as $price ) : ?>
	<a class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-mt-24 tutor-add-to-cart-button"
		href="
			<?php
			echo esc_url(
				add_query_arg(
					[
						'line_items' => [
							[
								'price_id' => $price->id,
								'quantity' => 1,
							],
						],
					],
					\SureCart::pages()->url( 'checkout' )
				)
			);
			?>
	">
		<sc-format-number type="currency" currency="<?php echo esc_attr( $price->currency ); ?>" value="<?php echo (int) $price->amount; ?>">
			<?php esc_html_e( 'Purchase', 'surecart' ); ?>
		</sc-format-number>
		&nbsp;
		<sc-format-interval value="<?php echo (int) $price->recurring_interval_count; ?>" interval="<?php echo esc_attr( $price->recurring_interval ); ?>"></sc-format-interval>
	</a>
<?php endforeach; ?>
