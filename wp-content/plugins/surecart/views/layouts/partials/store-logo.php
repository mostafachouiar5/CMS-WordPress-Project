<?php
$logo_url  = $logo_url ?? '';
$show_logo = $show_logo ?? true;
?>

<?php if ( $logo_url && $show_logo ) : ?>
	<img src="<?php echo esc_url( $logo_url ); ?>"
		style="max-width: <?php echo esc_attr( $logo_width ?? '130px' ); ?>; width: 100%; height: auto;"
		alt="<?php echo esc_attr( get_bloginfo() ); ?>"
	/>
<?php endif; ?>
