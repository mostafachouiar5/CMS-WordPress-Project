<div class="wrap">
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title' => __( 'Clicks', 'surecart' ),
		]
	);
	?>

	<?php $table->views(); ?>
	<?php $table->display(); ?>
</div>
