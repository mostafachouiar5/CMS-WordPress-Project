<?php
// let's make sure this page is not cached.
header( 'Cache-Control: no-cache, no-store, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );
?>

<?php \SureCart::render( 'components/admin/flash-messages' ); ?>

<h1 class="wp-heading-inline"><?php echo wp_kses_post( $title ?? '' ); ?></h1>

<?php if ( isset( $new_link ) ) : ?>
	<a href="<?php echo esc_url( $new_link ); ?>" class="page-title-action" data-test-id="add-new-button">
		<?php esc_html_e( 'Add New', 'surecart' ); ?>
	</a>
<?php endif; ?>

<?php if ( isset( $after_title ) ) : ?>
	<?php
	$allowed                   = wp_kses_allowed_html( 'post' );
	$allowed['button']['slot'] = true;
	echo wp_kses( $after_title, $allowed );
	?>
<?php endif; ?>

<hr class="wp-header-end" />
