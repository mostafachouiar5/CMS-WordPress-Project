<div class="wrap">
	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'    => __( 'Coupons', 'surecart' ),
			'new_link' => \SureCart::getUrl()->edit( 'coupon' ),
		]
	);
	?>

	<?php $table->search_form( __( 'Search Coupons', 'surecart' ), 'sc-search-coupons' ); ?>
	<?php $table->display(); ?>
</div>
