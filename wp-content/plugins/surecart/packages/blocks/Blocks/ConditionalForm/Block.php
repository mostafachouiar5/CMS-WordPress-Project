<?php

namespace SureCartBlocks\Blocks\ConditionalForm;

use SureCartBlocks\Blocks\BaseBlock;

/**
 * Cart CTA Block.
 */
class Block extends BaseBlock {
	/**
	 * Keep track of number of instances.
	 *
	 * @var integer
	 */
	public static $instance = 0;

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 * @param object $block Block object.
	 *
	 * @return string
	 */
	public function render( $attributes, $content, $block = null ) {
		self::$instance++;

		\SureCart::assets()->addComponentData(
			'sc-conditional-form',
			'#sc-conditional-form-' . (int) self::$instance,
			[
				'rule_groups' => $attributes['rule_groups'],
			]
		);

		return '<sc-conditional-form id="sc-conditional-form-' . (int) self::$instance . '">' . $content . '</sc-conditional-form>';
	}
}
