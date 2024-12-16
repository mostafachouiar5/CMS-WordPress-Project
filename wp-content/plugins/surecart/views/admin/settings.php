<!-- refresh this page every 15 minutes to prevent session from expiring -->
<meta http-equiv="refresh" content="1800" >

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
	<iframe id="sc-settings" src="<?php echo esc_url( $session_url ); ?>" width="100%" height="100%" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
	</div>
</div>

