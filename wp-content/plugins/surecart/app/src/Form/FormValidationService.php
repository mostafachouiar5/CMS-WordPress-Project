<?php

namespace SureCart\Form;

/**
 * Handles server-side form validation of gutenberg blocks.
 */
class FormValidationService {
	/**
	 * Holds the parsed blocks.
	 *
	 * @var array
	 */
	protected $blocks = [];

	/**
	 * The form post content.
	 *
	 * @var string
	 */
	protected $content = '';

	/**
	 * Params to validate.
	 *
	 * @var array
	 */
	protected $params = [];

	/**
	 * Get things going.
	 *
	 * @param string $content Post content.
	 * @param array  $params Params to validate.
	 */
	public function __construct( $content, $params = [] ) {
		$this->content = $content;
		$this->params  = $params;
	}

	/**
	 * Validate the form submission.
	 *
	 * @return true|WP_Error
	 */
	public function validate() {
		$this->blocks = parse_blocks( $this->content );
		return true;
	}

	/**
	 * Find required blocks recursively.
	 */
	public function findRequiredBlocks() {
		return $this->getNestedBlocksWhere( 'required', true );
	}

	/**
	 * Get nested block with a specific attribute/value pair.
	 *
	 * @param string $attribute Attribute name.
	 * @param any    $value The value.
	 * @return array
	 */
	protected function getNestedBlocksWhere( $attribute, $value ) {
		$blocks_with_requirements = $this->getNestedBlockWithAttribute( $this->blocks, 'required' );
		return array_filter(
			$blocks_with_requirements,
			function( $block ) use ( $attribute, $value ) {
				return $block['attrs'][ $attribute ] === $value;
			}
		);
	}

	/**
	 * Get nested values from an array
	 *
	 * @param array  $array Array to search.
	 * @param string $nested_key Nested key to search for.
	 * @return array
	 */
	protected function getNestedBlockWithAttribute( array $array, $nested_key ) {
		$return = array();
		array_walk_recursive(
			$array,
			function( $a, $key ) use ( &$return, $nested_key ) {
				if ( $nested_key === $key ) {
					$return[] = $a;
				}
			}
		);
		return $return;
	}
}
