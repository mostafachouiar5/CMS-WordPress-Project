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
		'label'       => __( 'Dropdown', 'wpengine-smart-search' ),
		'placeholder' => __( 'Dropdown...', 'wpengine-smart-search' ),
	)
);

// Generate unique input ID.
$input_id = 'wpengine-smart-dropdown-facet__input-' . ( ++$instance_id );
// Wrapper attributes.
$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => implode(
			' ',
			array_filter(
				array(
					'wpengine-smart-dropdown-facet',
					$attributes['align'] ? 'align' . $attributes['align'] : '',
				)
			)
		),
	)
);

$categories = get_categories(
	array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => 0,
	)
);


// Add initial state. This would be empty initially but other blocks can update this by merging the states together.
wp_interactivity_state(
	'wpengine-smart-search-facets__store',
	array(
		'allDropdownValues' => $categories,
	)
);
?>


<div <?php echo wp_kses_data( $wrapper_attributes ); ?>
	data-wp-interactive='{ "namespace": "wpengine-smart-search-facets__store" }'>
		<?php if ( $attributes['hasLabel'] ) : ?>
			<label for="<?php echo esc_attr( $input_id ); ?>" class="wpengine-smart-search-dropdown-facet__label">
				<?php echo esc_html( $attributes['label'] ); ?>
			</label>
		<?php else : ?>
			<label for="<?php echo esc_attr( $input_id ); ?>" class="wpengine-smart-search-dropdown-facet__label screen-reader-text">
				<?php echo esc_html( $attributes['label'] ); ?>
			</label>
		<?php endif; ?>

		<div class="wpengine-smart-dropdown-facet__fields">
			<select name="category_name" id="category_name" class="wpengine-smart-dropdown-facet__field" data-wp-on--change="actions.setDropdownValue" data-wp-bind--value="state.dropdownValue">
				<option value="" selected="selected">Please select...</option>
				<?php foreach ( $categories as $category ) : ?>
					<option value="<?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name ); ?> (<?php echo esc_html( $category->count ); ?>)</option>
				<?php endforeach; ?>
			</select>
		</div>
	</form>
</div>
