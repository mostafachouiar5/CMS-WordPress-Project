<div class="wrap">
	<?php \SureCart::render( 'layouts/partials/admin-index-styles' ); ?>
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title' => __( 'Licenses', 'surecart' ),
		]
	);
	?>

	<?php $table->search_form( __( 'Search Licenses', 'surecart' ), 'sc-search-licenses' ); ?>
	<?php $table->display(); ?>
</div>


