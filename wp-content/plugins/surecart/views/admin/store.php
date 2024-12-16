<?php \SureCart::render( 'layouts/partials/admin-settings-styles' ); ?>

<div id="sc-settings-container">
	<?php \SureCart::render( 'layouts/partials/admin-settings-header' ); ?>

	<div id="sc-settings-content">
		<?php
			\SureCart::render(
				'layouts/partials/admin-settings-sidebar',
				[
					'tab' => $tab,
				]
			);
			?>

		<div class="sc-container">
			<div id="app">Loading...</div>
		</div>
	</div>
</div>

