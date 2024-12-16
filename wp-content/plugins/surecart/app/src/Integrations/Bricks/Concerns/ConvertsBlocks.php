<?php

namespace SureCart\Integrations\Bricks\Concerns;

trait ConvertsBlocks {
	/**
	 * Show if we should populate content on empty.
	 *
	 * @var string
	 */
	public $show_populate_on_empty = false;

	/**
	 * Get the block html
	 *
	 * @param array  $block_attributes The block attributes.
	 * @param string $content          The block content.
	 *
	 * @return string
	 */
	protected function html( $block_attributes = [], $content = '' ) {
		// Previewing a template, show a placeholder to populate.
		if ( $this->show_populate_on_empty ) {
			$product = sc_get_product();

			if ( empty( $product ) ) {
				return $this->render_element_placeholder(
					[
						'title'       => esc_html__( 'For better preview select content to show.', 'surecart' ),
						'description' => esc_html__( 'Go to: Settings > Template Settings > Populate Content', 'surecart' ),
					]
				);
			}
		}

		// add the rendered class and id.
		$rendered_attributes           = $this->get_block_rendered_attributes();
		$block_attributes['className'] = $rendered_attributes['class'];
		$block_attributes['anchor']    = $rendered_attributes['id'];

		// get the bricks attributes.
		$key        = '_root';
		$attributes = apply_filters( 'bricks/element/render_attributes', $this->attributes, $key, $this );

		$block = sc_pre_render_blocks( '<!-- wp:' . $this->block_name . ' ' . ( is_array( $block_attributes ) ? wp_json_encode( $block_attributes, JSON_FORCE_OBJECT ) : '' ) . ' -->' . $content . '<!-- /wp:' . $this->block_name . ' -->' );

		// start the processor and select the first tag.
		$processor = new \WP_HTML_Tag_Processor( $block );
		$processor->next_tag();

		// Return: No attributes set for this element.
		if ( ! isset( $attributes[ $key ] ) ) {
			return $processor->get_updated_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		foreach ( $attributes[ $key ] as $name => $value ) {
			// handle array and filter out empty values.
			if ( is_array( $value ) ) {
				$value = array_filter(
					$value,
					function ( $val ) {
						return ! empty( $val ) || is_numeric( $val );
					}
				);
			}

			// handle class array.
			if ( 'class' === $name ) {
				foreach ( $value as $class ) {
					$processor->add_class( $class );
				}
				continue;
			}

			// handle the rest of the string value attributes.
			if ( is_string( $value ) ) {
				$processor->set_attribute( $name, $value );
			}
		}

		// return updated html.
		return $processor->get_updated_html();
	}

	/**
	 * Render the raw block output.
	 *
	 * @param array  $block_attributes The block attributes.
	 * @param string $content          The block content.
	 *
	 * @return string
	 */
	public function raw( $block_attributes = [], $content = '' ) {
		if ( $this->show_populate_on_empty ) {
			$product = sc_get_product();

			if ( empty( $product ) ) {
				return $this->render_element_placeholder(
					[
						'title'       => esc_html__( 'For better preview select content to show.', 'surecart' ),
						'description' => esc_html__( 'Go to: Settings > Template Settings > Populate Content', 'surecart' ),
					]
				);
			}
		}

		$rendered_attributes           = $this->get_block_rendered_attributes();
		$block_attributes['className'] = $rendered_attributes['class'];
		$block_attributes['anchor']    = $rendered_attributes['id'];

		return '<!-- wp:' . $this->block_name . ' ' . ( is_array( $block_attributes ) ? wp_json_encode( $block_attributes, JSON_FORCE_OBJECT ) : '' ) . ' -->' . $content . '<!-- /wp:' . $this->block_name . ' -->';
	}

	/**
	 * Preview block.
	 *
	 * @param string $content    The block content.
	 * @param string $class_name The class name.
	 * @param string $tag        The tag.
	 *
	 * @return string
	 */
	public function preview( $content = '', $class_name = '', $tag = 'div' ) {
		$rendered_attributes = $this->get_block_rendered_attributes();
		$class               = $class_name . ' ' . $rendered_attributes['class'];
		$id                  = $rendered_attributes['id'];

		$output  = "<$tag id='$id' class='$class'>";
		$output .= $content;
		$output .= "</$tag>";

		return $output;
	}

	/**
	 * Get the rendered attributes.
	 *
	 * @return array
	 */
	public function get_block_rendered_attributes(): array {
		$processor = new \WP_HTML_Tag_Processor( "<div {$this->render_attributes( '_root' )}></div>" );
		$processor->next_tag();

		$block_attributes['class'] = $processor->get_attribute( 'class' ) ?? '';
		$block_attributes['id']    = $processor->get_attribute( 'id' ) ?? '';

		return $block_attributes;
	}

	/**
	 * Whether it is editor or not.
	 *
	 * @return bool
	 */
	public function is_admin_editor() {
		return ! bricks_is_frontend() || bricks_is_builder_call();
	}

	/**
	 * Get raw color.
	 *
	 * @param string $key The key.
	 *
	 * @return string
	 */
	public function get_raw_color( $key ) {
		return $this->settings[ $key ]['hex'] ?? $this->settings[ $key ]['raw'] ?? '';
	}
}
