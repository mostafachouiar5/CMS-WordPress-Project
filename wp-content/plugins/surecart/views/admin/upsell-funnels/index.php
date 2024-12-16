<div class="wrap">
	<?php \SureCart::render( 'layouts/partials/admin-index-styles' ); ?>
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'    => __( 'Upsell Funnels', 'surecart' ),
			'new_link' => \SureCart::getUrl()->edit( 'upsell' ),
		]
	);
	?>

	<?php $table->display(); ?>
</div>

