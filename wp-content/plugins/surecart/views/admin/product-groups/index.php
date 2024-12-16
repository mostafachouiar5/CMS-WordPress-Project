
<div class="wrap">

	<?php
	echo wp_kses_post(
		\SureCart::notices()->render(
			[
				'name'  => 'product_groups_info',
				'title' => esc_html__( 'What are Upgrade Groups?', 'surecart' ),
				'text'  => esc_html__( 'An upgrade groups is how you define upgrade and downgrade paths for your customers. It is based on products they have previously purchased.', 'surecart' ),
			]
		)
	);
	?>

	<?php
	\SureCart::render(
		'layouts/partials/admin-index-header',
		[
			'title'    => __( 'Upgrade Groups', 'surecart' ),
			'new_link' => \SureCart::getUrl()->edit( 'product_group' ),
		]
	);
	?>

	<?php $table->display(); ?>
</div>

