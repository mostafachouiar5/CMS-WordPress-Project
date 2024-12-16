<!DOCTYPE html>
	<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

		<?php echo surecart_get_the_block_template_html( $content ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

		<?php wp_footer(); ?>
	</body>
</html>
