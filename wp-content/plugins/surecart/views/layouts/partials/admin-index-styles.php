<style>
	.column-mode {
		width: 50px;
	}
	.column-total, .column-status {
		min-width: 96px;
	}
	.column-order {
		width: 200px;
	}
	.column-fulfillment_status, .column-shipment_status {
		width: 120px;
	}

	:root:root {
	--wp-admin-theme-color: #2271b1;
	--wp-admin-theme-color-darker-10: #1f63a0;
	--wp-admin-theme-color-darker-20: #1a5080;
	--sc-color-primary-500: var(--wp-admin-theme-color);
	--sc-focus-ring-color-primary: var(--wp-admin-theme-color);
	--sc-input-border-color-focus: var(--wp-admin-theme-color);
	--sc-color-primary-text: #fff;
	}

	/* on mobile screens less than 1024px */
	@media (max-width: 1024px) {
		 .column-status {
			width: 96px;
		}
	}

	.sc-button-group {
		display: inline-flex;
	}
	.sc-button-group > :not(:first-child) {
		margin-left: -1px;
	}
</style>
