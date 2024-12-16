<?php

declare(strict_types=1);

namespace SureCart\BlockValidator;

/**
 * Class BlockValidator
 *
 * Validate and render blocks.
 *
 * @package SureCart\BlockValidator
 */
abstract class BlockValidator {
	/**
	 * The name of the block to validate.
	 *
	 * @var string
	 */
	protected $block_name = '';

	/**
	 * Validate block.
	 *
	 * The child class should implement this method.
	 *
	 * @param string $block_content The block content.
	 * @param array  $block The block.
	 *
	 * @return bool
	 */
	abstract protected function isValid( string $block_content, array $block ): bool;

	/**
	 * Render block.
	 *
	 * The child class should implement this method.
	 *
	 * @param string $block_content The block content.
	 * @param array  $block The block.
	 *
	 * @return string
	 */
	abstract protected function render( string $block_content, array $block ): string;

	/**
	 * Bootstrap the service.
	 * We only want to validate and render the block when the buy button renders.
	 *
	 * @return void
	 */
	public function bootstrap(): void {
		if ( ! $this->block_name ) {
			return;
		}
		add_action( 'render_block_' . $this->block_name, [ $this, 'validateAndRender' ], 10, 2 );
	}

	/**
	 * Validate and render block.
	 *
	 * @param string $block_content The block content.
	 * @param array  $block The block.
	 *
	 * @return string
	 */
	public function validateAndRender( string $block_content, array $block ): string {
		// If the content is valid, return the original content.
		if ( $this->isValid( $block_content, $block ) ) {
			return $block_content;
		}

		// Render the block - This should be implemented by the child class.
		return $this->render( $block_content, $block );
	}
}
