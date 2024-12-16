<?php

namespace SureCartBlocks\Blocks\PriceChoice;

use SureCart\Models\Price;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Checkout block
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
	 *
	 * @return string
	 */
	public function render( $attributes, $content ) {
		if ( empty( $attributes['price_id'] ) ) {
			return null;
		}

		$price = Price::with( array( 'product' ) )->find( $attributes['price_id'] );

		// empty check.
		if ( is_wp_error( $price ) || empty( $price->id ) ) {
			return null;
		}

		self::$instance++;

		\SureCart::assets()->addComponentData(
			'sc-price-choice',
			'#sc-price-choice-' . (int) self::$instance,
			[
				'price'   => $price->toArray(),
				'product' => $price->product->toArray(),
			]
		);

		if ( !empty($attributes['checked']) ) {
			sc_initial_state(
				[
					'checkout' => [
						'initialLineItems' => sc_initial_line_items(
							[
								[
									'price_id' => $price->id,
									'quantity' => $attributes['quantity'] ?? 1,
									'variant'  => $price->variant_id ?? null,
								],
							]
						),
					],
				]
			);
		}

		ob_start(); ?>
		<sc-price-choice
			id="sc-price-choice-<?php echo (int) self::$instance; ?>"
			price-id="<?php echo esc_attr( $attributes['price_id'] ?? '' ); ?>"
			type="<?php echo esc_attr( $attributes['type'] ?? 'radio' ); ?>"
			label="<?php echo esc_attr( $attributes['label'] ?? '' ); ?>"
			description="<?php echo esc_attr( $attributes['description'] ?? '' ); ?>"
			checked="<?php echo esc_attr( ! empty( $attributes['checked'] ) ? 'true' : 'false' ); ?>"
			show-label="<?php echo esc_attr( ! empty( $attributes['show_label'] ) ? 'true' : 'false' ); ?>"
			show-price="<?php echo esc_attr( wp_validate_boolean( $attributes['show_price'] ) ? 'true' : 'false' ); ?>"
			show-control="<?php echo esc_attr( ! empty( $attributes['show_control'] ) ? 'true' : 'false' ); ?>"
			quantity="<?php echo esc_attr( $attributes['quantity'] ?? '1' ); ?>"
		></sc-price-choice>
		<?php
		return ob_get_clean();
	}
}
