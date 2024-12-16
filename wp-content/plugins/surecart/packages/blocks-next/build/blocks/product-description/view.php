<?php
global $post;
?>
<?php if ( has_excerpt() ) : ?>
	<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'sc-prose' ] ) ); ?>>
		<?php echo wp_kses_post( $post->post_excerpt ); // make sure it is not truncated. ?>
	</div>
<?php endif; ?>
