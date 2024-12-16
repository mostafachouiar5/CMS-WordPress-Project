<?php \SureCart::render( 'layouts/partials/admin-settings-styles' ); ?>

<div id="sc-settings-container">
	<?php
	\SureCart::render(
		'layouts/partials/admin-settings-header',
		[
			'claim_url'  => $claim_url,
			'breadcrumb' => $breadcrumb,
		]
	);
	?>

	<div id="sc-settings-content">
		<?php
			\SureCart::render(
				'layouts/partials/admin-settings-sidebar',
				[
					'tab'          => $tab,
					'is_free'      => $is_free,
					'entitlements' => $entitlements,
					'upgrade_url'  => $upgrade_url,
				]
			);
			?>

		<div class="sc-container">
			<div class="sc-content" id="app"></div>
		</div>
	</div>
</div>

