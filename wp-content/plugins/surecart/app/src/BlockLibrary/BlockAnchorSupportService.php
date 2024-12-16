<?php

namespace SureCart\BlockLibrary;

/**
 * Provide anchor support for blocks.
 */
class BlockAnchorSupportService {
	/**
	 * Register anchor support
	 *
	 * @param WP_Block_Type $block_type Block Type.
	 *
	 * @return void
	 */
	public function registerAnchorSupport( $block_type ) {
		$has_anchor_support = block_has_support( $block_type, 'anchor', false );

		if ( $has_anchor_support ) {
			if ( ! $block_type->attributes ) {
				$block_type->attributes = array();
			}

			if ( ! array_key_exists( 'anchor', $block_type->attributes ) ) {
				$block_type->attributes['anchor'] = array(
					'type' => 'string',
				);
			}
		}
	}

	/**
	 * Add the anchor to the output.
	 *
	 * @param WP_Block_Type $block_type Block Type.
	 * @param array         $block_attributes Block attributes.
	 *
	 * @return array Block CSS classes and inline styles.
	 */
	public function applyAnchorSupport( $block_type, $block_attributes ) {
		// exclude kadence blocks.
		if ( isset( $block_attributes['kbVersion'] ) ) {
			return $block_attributes;
		}

		$has_anchor_support = block_has_support( $block_type, 'anchor', false );
		$attributes         = array();
		if ( $has_anchor_support ) {
			$has_anchor = array_key_exists( 'anchor', $block_attributes );

			if ( $has_anchor ) {
				$attributes['id'] = $block_attributes['anchor'];
			}
		}

		return $attributes;
	}

	/**
	 * Register block support.
	 *
	 * @return void
	 */
	public function bootstrap() {
		\WP_Block_Supports::get_instance()->register(
			'anchor',
			array(
				'register_attribute' => [ $this, 'registerAnchorSupport' ],
				'apply'              => [ $this, 'applyAnchorSupport' ],
			)
		);
	}
}
