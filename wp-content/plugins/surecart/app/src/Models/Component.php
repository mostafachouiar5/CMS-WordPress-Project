<?php

namespace SureCart\Models;

class Component {
	/**
	 * Holds the data for the component.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Holds the component tag.
	 *
	 * @var string
	 */
	protected $tag = '';

	/**
	 * Holds the component id selector.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Prevent php warnings.
	 */
	final public function __construct() {}

	/**
	 * Data to pass to the component.
	 *
	 * @param array $args Args to pass.
	 * @return this
	 */
	protected function with( $args ) {
		$this->data = apply_filters( 'surecart/components/props', array_merge( $this->data, $args ), $this->tag, $this );
		return $this;
	}

	/**
	 * Set the tag for the component.
	 *
	 * @param string $tag Tag for the component.
	 * @return this
	 */
	protected function tag( $tag ) {
		$this->tag = $tag;
		return $this;
	}

	/**
	 * Set the id for the component.
	 *
	 * @param string $id The id to set.
	 * @return this
	 */
	protected function id( $id ) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Render the component.
	 *
	 * @param string $inner_html Inner html for the component.
	 * @return string
	 */
	protected function render( $inner_html = '' ) {
		\SureCart::assets()->addComponentData(
			$this->tag,
			"#$this->id",
			$this->data
		);
		return "<$this->tag id='$this->id'>$inner_html</$this->tag>";
	}

	/**
	 * Forward call to method
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 */
	public function __call( $method, $params ) {
		return call_user_func_array( [ $this, $method ], $params );
	}

	/**
	 * Static Facade Accessor
	 *
	 * @param string $method Method to call.
	 * @param mixed  $params Method params.
	 *
	 * @return mixed
	 */
	public static function __callStatic( $method, $params ) {
		return call_user_func_array( [ new static(), $method ], $params );
	}
}
