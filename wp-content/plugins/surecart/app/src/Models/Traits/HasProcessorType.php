<?php

namespace SureCart\Models\Traits;

/**
 * If the model has an attached customer.
 */
trait HasProcessorType {
	/**
	 * Processor type
	 *
	 * @var string
	 */
	protected $processor_type = '';

	/**
	 * Set the processor type
	 *
	 * @param string $type The processor type.
	 * @return $this
	 */
	protected function setProcessor( $type ) {
		$this->processor_type = $type;
		return $this;
	}
}
