<?php

namespace SureCart\Models\Traits;

trait HasBillingAddress {
	/**
	 * Always set billing address as object.
	 *
	 * @param array|object $value Value to set.
	 * @return $this
	 */
	protected function setBillingAddressAttribute( $value ) {
		$this->attributes['billing_address'] = (object) $value;
		return $this;
	}
}
