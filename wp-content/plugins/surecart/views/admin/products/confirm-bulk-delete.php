<style>
	#wpwrap {
		--sc-color-primary-500: var(--sc-color-danger-500);
		background: var(--sc-color-brand-main-background);
	}

	.wrap .container {
		width: 100%;
		padding-top: 3em;
	}

	.wrap .container  sc-card {
		width: 100%;
		max-width: 600px;
	}

	.sc-modal-icon {
		font-size: 24px;
		color: var(--sc-color-primary-500);
	}

	.wrap .container .button-container {
		gap: 1em;
	}

	.sc-product-list {
		font-size: 13px;
	}

	.sc-product-list li a {
		display: flex;
		align-items: center;
		gap: 0.5em;
		color: var(--sc-color-primary-500);
	}

</style>
<div class="wrap">
	<?php \SureCart::render( 'layouts/partials/admin-index-styles' ); ?>

	<sc-flex justify-content="center" class="container">
		<sc-card style="--sc-card-padding: var(--sc-spacing-xxx-large)">
			<form action="" method="post">
				<?php wp_nonce_field( 'bulk_delete_nonce', 'nonce' ); ?>
				<input type="hidden" name="confirm-bulk-delete" value="true" />
				<sc-flex flex-direction="column" style="--sc-flex-column-gap:1em;">
					<sc-icon name="alert-triangle" class="sc-modal-icon"></sc-icon>

					<sc-heading size="large"><?php esc_html_e( 'Delete Products', 'surecart' ); ?></sc-heading>

					<sc-text>
						<?php echo esc_html( _n( 'Are you sure you want to permanently delete this product? This cannot be undone.', 'Are you sure you want to permanently delete these products? This cannot be undone.', count( $products ), 'surecart' ) ); ?>
					</sc-text>

					<ul class="sc-product-list">
						<?php foreach ( $products as $product ) : ?>
							<li>
								<a href="<?php echo esc_url( \SureCart::getUrl()->edit( 'product', $product->id ) ); ?>" target="_blank">
									<?php echo wp_kses_post( $product->name ); ?>
									<sc-icon name="external-link"></sc-icon>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>

					<sc-flex class="button-container" justify-content="flex-start">
						<sc-button size="medium" type="primary" submit><?php esc_html_e( 'Delete', 'surecart' ); ?></sc-button>
						<sc-button href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : get_home_url() ); ?>" size="medium" type="link"><?php esc_html_e( 'Cancel', 'surecart' ); ?></sc-button>
					</sc-flex>
				</sc-flex>
			</form>
		</sc-card>
	</sc-flex>
</div>
