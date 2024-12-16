<div class="wrap">
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'    => __( 'Affiliate Requests', 'surecart' ),
			'new_link' => \SureCart::getUrl()->edit( 'affiliate-requests' ),
		]
	);
	?>

	<?php $table->search_form( __( 'Search', 'surecart' ), 'sc-search-affiliate-requests' ); ?>

	<form id="affiliate-requests-filter" method="get">
		<?php $table->views(); ?>
		<?php $table->display(); ?>
	</form>
</div>
