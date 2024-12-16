<?php
/*
Template Name: SureCart
*/

use SureCartBlocks\Blocks\Form\Block as FormBlock;

// this needs to happen before wp_head to ensure that blocks can add scripts and styles in wp_head().
global $post;
$post = $product->post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
setup_postdata( $product->post );
ob_start();
require 'buy-template.php';
$content = ob_get_clean();

$template_html = filter_block_content(
	( new FormBlock() )->render(
		[
			'product'     => $product,
			'mode'        => $mode,
			'success_url' => $success_url,
		],
		do_blocks( $content )
	),
);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<style>
	/** block editor theme fix. */
	body .is-layout-constrained > * + * {
		margin-top: 0;
	}
	</style>
</head>

<body <?php body_class( 'sc-buy-page' ); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'surecart_buy_page_body_open' ); ?>

	<header class="sc-buy-header">
		<div class="sc-buy-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( ! empty( $show_logo ) && ! empty( $logo_url ) ) : ?>
					<img src="<?php echo esc_url( $logo_url ?? '' ); ?>"
						style="max-width: <?php echo esc_attr( $logo_width ?? '180px' ); ?>; width: 100%; height: auto;"
						alt="<?php echo esc_attr( get_bloginfo() ); ?>"
					/>
				<?php endif; ?>
			</a>
			<?php if ( empty( $enabled ) ) : ?>
				<sc-tag type="warning" size="small">
					<?php esc_html_e( 'Not Published', 'surecart' ); ?>
				</sc-tag>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $user->ID ) ) : ?>
			<sc-dropdown position="bottom-right" style="font-size: 15px;">
				<sc-avatar image="<?php echo esc_url( get_avatar_url( $user->user_email, [ 'default' => '404' ] ) ); ?>" style="--sc-avatar-size: 34px"  role="button" tabindex="0" initials="<?php echo esc_attr( substr( $user->display_name, 0, 1 ) ); ?>"></sc-avatar>
				<sc-menu>
					<?php if ( ! empty( $dashboard_link ) ) : ?>
						<sc-menu-item href="<?php echo esc_url( $dashboard_link ); ?>">
							<?php esc_html_e( 'Dashboard', 'surecart' ); ?>
						</sc-menu-item>
					<?php endif; ?>

					<?php if ( ! empty( $logout_link ) ) : ?>
						<sc-menu-item href="<?php echo esc_url( $logout_link ); ?>">
							<?php esc_html_e( 'Logout', 'surecart' ); ?>
						</sc-menu-item>
					<?php endif; ?>
				</sc-menu>
			</sc-dropdown>
		<?php endif; ?>
	</header>


	<?php echo $template_html; ?>

	<?php wp_footer(); ?>
</body>
</html>
