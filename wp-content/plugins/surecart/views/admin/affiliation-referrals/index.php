<style>
	.row-actions .approve {
		display: inline !important;
	}
</style>

<?php \SureCart::render( 'layouts/partials/admin-index-styles' ); ?>

<?php
$mode = sanitize_text_field( wp_unslash( $_GET['mode'] ?? '' ) );
if ( ! empty( $mode ) && 'test' === $mode ) {
	?>
	<div class="notice notice-info" style="padding-top: var(--sc-spacing-medium);">
		<sc-text tag="h2" style="--font-size: var(--sc-font-size-x-large);--font-weight:bold;">
			<?php esc_html_e( 'What are test mode referrals?', 'surecart' ); ?>
		</sc-text>
		<p><?php esc_html_e( 'Test mode referrals are created when an order is placed in test mode and an affiliate is associated with the order. These referrals do not impact stats, are not included in payouts, and are not visible to affiliates. They are solely for testing your affiliate setup and can be deleted or ignored.', 'surecart' ); ?></p>
	</div>
	<?php
}
?>

<div class="wrap">
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'    => __( 'Affiliate Referrals', 'surecart' ),
			'new_link' => \SureCart::getUrl()->edit( 'affiliate-referral' ),
		]
	);
	?>

	<form id="posts-filter" method="get">
		<?php $table->views(); ?>
		<?php $table->display(); ?>

		<div id="ajax-response"></div>
	</form>
</div>

<script>
	const deleteLinks = document.querySelectorAll( '.row-actions .delete>a' );
	Array.from( deleteLinks ).forEach( button => {
		button.addEventListener( 'click', event => {
			event.preventDefault();
			const confirmed = confirm("<?php echo esc_js( __( 'Are you sure you want to delete this referral? This action cannot be undone.', 'surecart' ) ); ?>")
			if ( confirmed ) {
				window.location.href = event.target.href;
			}
		} );
	} );
</script>
