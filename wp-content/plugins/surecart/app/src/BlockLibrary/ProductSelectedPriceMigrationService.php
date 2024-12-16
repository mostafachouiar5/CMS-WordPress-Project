<?php

namespace SureCart\BlockLibrary;

/**
 * Provide the migration service for the product price block.
 */
class ProductSelectedPriceMigrationService {
	/**
	 * Attributes
	 *
	 * @var array
	 */
	public array $attributes = array();

	/**
	 * Block.
	 *
	 * @var object
	 */
	public ?object $block = null;

	/**
	 * Block HTML.
	 *
	 * @var string
	 */
	public string $block_html = '';

	/**
	 * Constructor
	 *
	 * @param array  $attributes Attributes.
	 * @param object $block Block.
	 */
	public function __construct( $attributes = array(), $block = null ) {
		$this->attributes = $attributes;
		$this->block      = $block;
	}

	/**
	 * Get content alignment
	 *
	 * @return string
	 */
	public function getContentAlignment() {
		return $this->attributes['alignment'] ?? 'left';
	}

	/**
	 * Render the sales badge.
	 *
	 * @return void
	 */
	public function renderSalesBadge() {
		$badge_attributes = array(
			'text'  => $this->attributes['sale_text'] ?? __( 'Sale', 'surecart' ),
			'style' => array(
				'border'     => array(
					'radius' => '15px',
				),
				'typography' => array(
					'fontSize' => '12px',
				),
				'layout'     => array(
					'selfStretch' => 'fit',
					'flexSize'    => null,
				),
			),
		);

		$this->block_html .= '<!-- wp:surecart/product-sale-badge ' . wp_json_encode( $badge_attributes ) . ' /-->';
	}

	/**
	 * Render the price scratch amount, selected price and sales badge.
	 *
	 * @return void
	 */
	public function renderAmountLine() {
		$scratch_block_attributes = array_merge(
			$this->attributes,
			array(
				'style' => array(
					'typography' => array(
						'textDecoration' => 'line-through',
						'fontSize'       => '24px',
						'lineHeight'     => '1.4',
					),
					'color'      => array(
						'text' => $attributes['textColor'] ?? '#8a8a8a',
					),
				),
			)
		);
		$amount_block_attributes  = array_merge(
			$this->attributes,
			array(
				'style' => array(
					'typography' => array(
						'fontSize'   => '24px',
						'lineHeight' => '1.4',
					),
					'color'      => array(
						'text' => $attributes['textColor'] ?? '#8a8a8a',
					),
				),
			)
		);

		$interval_block_attributes = array_merge(
			$this->attributes,
			array(
				'style' => array(
					'typography' => array(
						'fontSize'   => '18px',
						'lineHeight' => '1.8',
					),
					'color'      => array(
						'text' => $attributes['textColor'] ?? '#8a8a8a',
					),
				),
			)
		);

		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"' . $this->getContentAlignment() . '","verticalAlignment":"bottom"}} -->';
		$this->block_html .= '<div class="wp-block-group">';
		$this->block_html .= '<!-- wp:surecart/product-selected-price-scratch-amount ' . wp_json_encode( $scratch_block_attributes ) . ' /-->';
		$this->block_html .= '<!-- wp:surecart/product-selected-price-amount ' . wp_json_encode( $amount_block_attributes ) . ' /-->';
		$this->block_html .= '<!-- wp:surecart/product-selected-price-interval ' . wp_json_encode( $interval_block_attributes ) . ' /-->';

		$this->renderSalesBadge();
		$this->block_html .= '</div>';
		$this->block_html .= '<!-- /wp:group -->';
	}

	/**
	 * Render selected price trial and fees.
	 *
	 * @return void
	 */
	public function renderSelectedPriceTrialAndFees() {
		$child_block_attributes = array_merge(
			$this->attributes,
			array(
				'style' => array(
					'color'    => array(
						'text' => $attributes['textColor'] ?? '#8a8a8a',
					),
					'elements' => array(
						'link' => array(
							'color' => array(
								'text' => $attributes['textColor'] ?? '#8a8a8a',
							),
						),
					),
				),
			)
		);

		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"blockGap":"0.5em"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"' . $this->getContentAlignment() . '"}} -->';
		$this->block_html .= '<div class="wp-block-group" >';
		$this->block_html .= '<!-- wp:surecart/product-selected-price-trial ' . wp_json_encode( $child_block_attributes ) . ' /-->';
		$this->block_html .= '<!-- wp:surecart/product-selected-price-fees ' . wp_json_encode( $child_block_attributes ) . ' /-->';
		$this->block_html .= '</div>';
		$this->block_html .= '<!-- /wp:group -->';
	}

	/**
	 * Render the price.
	 *
	 * @return void
	 */
	public function renderPrice() {
		$group_attributes = array(
			'style' => array(
				'spacing' => $this->attributes['style']['spacing'] ?? array(
					'blockGap' => '0px',
				),
			),
		);

		if ( ! empty( $this->attributes['backgroundColor'] ) ) {
			$group_attributes['backgroundColor'] = $this->attributes['backgroundColor'];
		}

		if ( ! empty( $this->attributes['style']['color']['background'] ) ) {
			$group_attributes['style']['color']['background'] = $this->attributes['style']['color']['background'];
		}

		$group_block      = parse_blocks( '<!-- wp:group ' . wp_json_encode( $group_attributes ) . ' -->' ) [0] ?? null;
		$group_styles     = sc_get_block_styles( true, $group_block );
		$group_classnames = $group_styles['classnames'] ?? '';
		$group_css        = $group_styles['css'] ?? '';

		$this->block_html .= '<!-- wp:group ' . wp_json_encode( $group_attributes ) . ' -->';
		$this->block_html .= '<div class="wp-block-group ' . $group_classnames . '" style="' . $group_css . '">';
		$this->renderAmountLine();
		$this->renderSelectedPriceTrialAndFees();
		$this->block_html .= '</div>';
		$this->block_html .= '<!-- /wp:group -->';
	}

	/**
	 * Render blocks.
	 *
	 * @return string
	 */
	public function doBlocks() {
		return do_blocks( $this->block_html );
	}

	/**
	 * Render the new price.
	 *
	 * @return string
	 */
	public function render() {
		$this->renderPrice();
		return $this->doBlocks();
	}
}
