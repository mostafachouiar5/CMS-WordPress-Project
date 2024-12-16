<style>

	.wp-list-table {
		table-layout: auto !important;
	}
</style>
<div class="wrap">

	<?php
	\SureCart::render( 'layouts/partials/admin-index-styles' );
	?>

	<div id="app"></div>

	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title' => __( 'Subscriptions', 'surecart' ),
		]
	);
	?>

	<?php $table->search_form( __( 'Search Subscriptions', 'surecart' ), 'sc-search-subscriptions' ); ?>
	<form id="posts-filter" method="get">
		<?php $table->views(); ?>
		<?php $table->display(); ?>
		<div id="ajax-response"></div>
	</form>
</div>
