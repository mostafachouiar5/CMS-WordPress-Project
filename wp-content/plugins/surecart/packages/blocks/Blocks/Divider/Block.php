<?php

namespace SureCartBlocks\Blocks\Divider;

/**
 * Logout Button Block.
 */
class Block {
	/**
	 * Optional directory to .json block data files.
	 *
	 * @var string
	 */
	protected $directory = '';

	/**
	 * Register the block for dynamic output
	 *
	 * @return void
	 */
	public function register() {
		register_block_type_from_metadata(
			$this->getDir(),
		);
	}

	/**
	 * Get the called class directory path
	 *
	 * @return string
	 */
	public function getDir() {
		$reflector = new \ReflectionClass( $this );
		$fn        = $reflector->getFileName();
		return dirname( $fn );
	}
}
