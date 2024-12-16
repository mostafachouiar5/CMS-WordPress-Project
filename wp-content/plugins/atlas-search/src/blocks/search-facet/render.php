<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @phpcs:disable Squiz.Commenting.FileComment.MissingPackageTag
 */

// Generate unique id for aria-controls.
// Static instance ID.
static $instance_id = 0;

// Default attributes.
$attributes = wp_parse_args(
	$attributes,
	array(
		'hasLabel'    => true,
		'align'       => '',
		'className'   => '',
		'label'       => __( 'Search', 'wpengine-smart-search' ),
		'placeholder' => __( 'Search...', 'wpengine-smart-search' ),
	)
);

// Generate unique input ID.
$input_id = 'wpengine-smart-search-facet__input-' . ( ++$instance_id );
// Wrapper attributes.
$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => implode(
			' ',
			array_filter(
				array(
					'wpengine-smart-search-facet',
					$attributes['align'] ? 'align' . $attributes['align'] : '',
				)
			)
		),
	)
);

// Add initial state. This would be empty initially but other blocks can update this by merging the states together.
wp_interactivity_state(
	'wpengine-smart-search-facets__store',
	array(
		'filters' => array(),
	)
);

?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?>
	data-wp-interactive='{ "namespace": "wpengine-smart-search-facets__store" }'>
	<form role="search" method="get" data-wp-on--submit="actions.performSearch">
		<?php if ( $attributes['hasLabel'] ) : ?>
			<label for="<?php echo esc_attr( $input_id ); ?>" class="wpengine-smart-search-facet__label">
				<?php echo esc_html( $attributes['label'] ); ?>
			</label>
		<?php else : ?>
			<label for="<?php echo esc_attr( $input_id ); ?>" class="wpengine-smart-search-facet__label screen-reader-text">
				<?php echo esc_html( $attributes['label'] ); ?>
			</label>
		<?php endif; ?>

		<div class="wpengine-smart-search-facet__fields">
			<input type="search" id="<?php echo esc_attr( $input_id ); ?>" class="wpengine-smart-search-facet__field"
				placeholder="<?php echo esc_attr( $attributes['placeholder'] ); ?>" name="s"
				data-wp-bind--value="state.searchValue" data-wp-on--input="actions.setSearchValue"/>
			<button type="submit" class="wpengine-smart-search-facet__button" onclick=""
				aria-label="<?php echo esc_attr__( 'Search', 'wpengine-smart-search' ); ?>">
				Search
			</button>
		</div>
	</form>
</div>
