<div class="wrap">
	<?php
		\SureCart::render( 'layouts/partials/admin-index-styles' );
	?>
	<?php
	if ( ! $enabled ) :
		\SureCart::render(
			'admin/cancellation-insights/cta-banner',
		);
		endif;
	?>

	<?php if ( $enabled ) : ?>
		<div id="app"></div>
	<?php endif; ?>

	<?php
		\SureCart::render(
			'layouts/partials/admin-index-header',
			[ 'title' => __( 'Cancellation Attempts', 'surecart' ) ]
		);
		?>
	<form id="posts-filter" method="get">
		<?php $table->display(); ?>

		<div id="ajax-response"></div>
	</form>
</div>
