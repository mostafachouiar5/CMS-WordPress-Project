<?php
/*
Template Name: SureCart
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'surecart_template_blank_body_open' ); ?>

<?php
while ( have_posts() ) :
	the_post();
	the_content();
	endwhile;
?>

<?php wp_footer(); ?>
</body>
</html>
