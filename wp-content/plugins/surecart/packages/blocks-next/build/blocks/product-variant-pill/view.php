<?php
printf(
	'<style>div.sc-pill-option__button--selected,div.sc-pill-option__button--selected:hover,div.sc-pill-option__button--selected:focus{background-color:%s!important;color:%s!important;border-color:%s!important;}</style>',
	esc_attr( $attributes['highlight_background'] ?? '' ),
	esc_attr( $attributes['highlight_text'] ?? '' ),
	esc_attr( $attributes['highlight_border'] ?? '' )
);

printf(
	'<style>div.sc-pill-option__button:hover:not(.sc-pill-option__button--selected){background-color:%s!important;color:%s!important;border-color:%s!important;}</style>',
	esc_attr( $attributes['highlight_text'] ?? '' ),
	esc_attr( $attributes['highlight_background'] ?? '' ),
	esc_attr( $attributes['highlight_background'] ?? '' )
);

?>

<div
<?php echo wp_kses_data( get_block_wrapper_attributes( array( 'class' => 'sc-pill-option__button' ) ) ); ?>
<?php
echo wp_kses_data(
	wp_interactivity_data_wp_context(
		array(
			'option_value'      => $block->context['value'],
			'option_name'       => $block->context['name'],
			'option_name_slug'  => sanitize_title( $block->context['name'] ),
			'option_value_slug' => sanitize_title( $block->context['value'] ),
		)
	)
);
?>
data-wp-on--click="callbacks.setOption"
data-wp-class--sc-pill-option__button--selected="state.isOptionSelected"
data-wp-class--sc-pill-option__button--disabled="state.isOptionUnavailable"
data-wp-bind--aria-checked="state.isOptionSelected"
data-wp-bind--aria-disabled="state.isOptionUnavailable"
role="radio"
tabindex="0"
data-wp-on--keydown="callbacks.setOption"
>
	<span class="sc-screen-reader-text">
		<?php
		printf(
			// translators: %s is the name of the variant option.
			esc_html__( 'Select %s', 'surecart' ),
			esc_html(
				$block->context['name']
			)
		);
		?>
	</span>
	<?php echo esc_html( $block->context['value'] ); ?>
</div>
