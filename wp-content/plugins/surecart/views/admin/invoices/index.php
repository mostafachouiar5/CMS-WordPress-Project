<div class="wrap">
	<?php \SureCart::render( 'layouts/partials/admin-index-styles' ); ?>
	<style>.column-invoice { width: 175px}</style>
	<?php
	$live_mode = isset( $_GET['live_mode'] ) ? sanitize_text_field( wp_unslash( $_GET['live_mode'] ) ) : 'true';

	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title' => __( 'Invoices', 'surecart' ),
			'after_title' => \SureCart::view( 'admin/invoices/new-invoice-button' )->toString(),
		]
	);
	?>

	<?php $table->search_form( __( 'Search Invoices', 'surecart' ), 'sc-search-invoices' ); ?>

	<form id="posts-filter" method="get">
		<?php $table->views(); ?>
		<?php $table->display(); ?>

		<div id="ajax-response"></div>
	</form>
</div>

