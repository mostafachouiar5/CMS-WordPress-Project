<?php
// defaults.
$is_mobile          = $is_mobile ?? false;
$show_account       = $show_account ?? false;
$navigation         = $navigation ?? [];
$account_navigation = $account_navigation ?? [];
?>

<?php echo ! empty( $is_mobile ) ? '<sc-menu>' : '<sc-spacing style="--spacing: var(--sc-spacing-xx-small);">'; ?>

	<?php foreach ( $navigation as $key => $item ) : ?>
		<?php
		\SureCart::render(
			'layouts/partials/customer-dashboard/dashboard-menu-item',
			[
				'icon_name' => $item['icon_name'],
				'name'      => $item['name'],
				'active'    => $item['active'],
				'href'      => $item['href'],
				'is_mobile' => $is_mobile,
			]
		);
		?>
	<?php endforeach; ?>

	<?php if ( $show_account ) : ?>
		<sc-menu-divider></sc-menu-divider>

		<?php foreach ( $account_navigation as $navigation ) : ?>
			<?php
			\SureCart::render(
				'layouts/partials/customer-dashboard/dashboard-menu-item',
				[
					'icon_name' => $navigation['icon_name'],
					'name'      => $navigation['name'],
					'active'    => $navigation['active'],
					'href'      => $navigation['href'],
					'is_mobile' => $is_mobile,
				]
			);
			?>
		<?php endforeach; ?>

		<?php if ( ! empty( $account_navigation ) ) : ?>
			<sc-menu-divider></sc-menu-divider>
		<?php endif; ?>

		<?php
		\SureCart::render(
			'layouts/partials/customer-dashboard/dashboard-menu-item',
			[
				'icon_name' => 'log-out',
				'name'      => __( 'Log Out', 'surecart' ),
				'active'    => false,
				'href'      => $data['logout_link'] ?? wp_logout_url( get_permalink() ),
				'is_mobile' => $is_mobile,
			]
		);
		?>
	<?php endif; ?>

<?php
echo ! empty( $is_mobile ) ? '</sc-menu>' : '</sc-spacing>';
