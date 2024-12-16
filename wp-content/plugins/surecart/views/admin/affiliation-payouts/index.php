<style>
	.row-actions .approve {
		display: inline !important;
	}
</style>

<div class="wrap">
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'       => __( 'Affiliate Payouts', 'surecart' ),
			'after_title' => \SureCart::view( 'admin/affiliation-payouts/new-payout-button' )->toString(),
		]
	);
	?>

	<?php $table->views(); ?>
	<?php $table->display(); ?>
</div>
