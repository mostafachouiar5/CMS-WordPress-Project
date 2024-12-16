<?php

namespace SureCart\BlockLibrary;

/**
 * Provide the migration service for the product price choices block.
 */
class ProductPriceChoicesMigrationService {
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
	 * Render the price name.
	 *
	 * @return void
	 */
	public function renderPriceName() {
		$this->block_html .= '<!-- wp:surecart/price-name {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"},"typography":{"fontStyle":"normal","fontWeight":"600"}}} /-->';
	}

	/**
	 * Render the price amount, trial and setup fee.
	 *
	 * @return void
	 */
	public function renderPriceAmountScratchAmountTrialAndSetupFee() {
		$text_color        = $this->attributes['textColor'] ?? '#8a8a8a';
		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"blockGap":"0px"},"layout":{"selfStretch":"fixed","flexSize":"50%"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"right"}} -->';
		$this->block_html .= '<div class="wp-block-group">';
		$this->block_html .= '<!-- wp:group {"style":{"spacing":{"blockGap":"0.5rem"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->';
		$this->block_html .= '<div class="wp-block-group">';
		$this->block_html .= '<!-- wp:surecart/price-scratch-amount {"style":{"typography":{"textDecoration":"line-through"}},"color":{"text":"#686868"}} /-->';
		$this->block_html .= '<!-- wp:surecart/price-amount {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}}} /-->';
		$this->block_html .= '<!-- wp:surecart/price-interval {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}}} /-->';
		$this->block_html .= '</div>';
		$this->block_html .= '<!-- /wp:group -->';
		$this->block_html .= '<!-- wp:surecart/price-trial {"style":{"color":{"text":"' . $text_color . '"},"elements":{"link":{"color":{"text":"' . $text_color . '"}}}},"fontSize":"small"} /-->';
		$this->block_html .= '<!-- wp:surecart/price-setup-fee {"style":{"color":{"text":"' . $text_color . '"},"elements":{"link":{"color":{"text":"' . $text_color . '"}}}},"fontSize":"small"} /-->';
		$this->block_html .= '</div>';
		$this->block_html .= '<!-- /wp:group -->';
	}

	/**
	 * Render the price choices.
	 *
	 * @return void
	 */
	public function renderPriceChoices() {
		$choices_attributes = array(
			'label' => $this->attributes['label'] ?? __( 'Pricing', 'surecart' ),
		);

		$template_attributes = array(
			'layout'          => [
				'type'           => 'flex',
				'justifyContent' => 'left',
				'flexWrap'       => 'nowrap',
				'orientation'    => 'horizontal',
			],
			'textColor'       => $this->attributes['textColor'] ?? 'black',
			'backgroundColor' => $this->attributes['backgroundColor'] ?? 'white',
			'style'           => $this->attributes['style'] ?? [],
		);

		$this->block_html .= '<!-- wp:surecart/product-price-chooser ' . wp_json_encode( $choices_attributes ) . ' -->';
		$this->block_html .= '<!-- wp:surecart/product-price-choice-template ' . wp_json_encode( $template_attributes ) . ' -->';
		$this->renderPriceName();
		if ( $this->attributes['show_price'] ) {
			$this->renderPriceAmountScratchAmountTrialAndSetupFee();
		}
		$this->block_html .= '<!-- /wp:surecart/product-price-choice-template -->';
		$this->block_html .= '<!-- /wp:surecart/product-price-chooser -->';
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
	 * Render the product price choices.
	 *
	 * @return string
	 */
	public function render() {
		$this->renderPriceChoices();
		return $this->doBlocks();
	}
}
