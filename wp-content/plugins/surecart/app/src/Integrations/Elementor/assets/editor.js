jQuery(window).ready(function () {
	if (typeof elementor === 'undefined') {
		return;
	}

	// Form edit link
	elementor.channels.editor.on('surecart:form:edit', function (view) {
		let block_id = view.elementSettingsModel.get('sc_form_block');
		if (!block_id) {
			return;
		}

		let win = window.open(
			scElementorData.site_url +
				`/wp-admin/post.php?post=${block_id}&action=edit`,
			'_blank'
		);
		win.focus();
	});

	// Form create link
	elementor.channels.editor.on('surecart:form:create', function () {
		let win = window.open(
			scElementorData.site_url +
				`/wp-admin/post-new.php?post_type=sc_form`,
			'_blank'
		);
		win.focus();
	});
});
