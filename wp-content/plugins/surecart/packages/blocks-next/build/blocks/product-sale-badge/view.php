<div <?php echo wp_kses_data( get_block_wrapper_attributes( array( 'class' => 'sc-tag sc-tag--primary' ) ) ); ?>
	data-wp-bind--hidden="!state.isOnSale"
	hidden>
	<?php echo wp_kses_post( $attributes['text'] ); ?>
</div>
