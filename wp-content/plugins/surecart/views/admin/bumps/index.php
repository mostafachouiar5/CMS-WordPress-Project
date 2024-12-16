
<div class="wrap">

	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'    => __( 'Bumps', 'surecart' ),
			'new_link' => \SureCart::getUrl()->edit( 'bump' ),
		]
	);
	?>

	<?php $table->display(); ?>
</div>

