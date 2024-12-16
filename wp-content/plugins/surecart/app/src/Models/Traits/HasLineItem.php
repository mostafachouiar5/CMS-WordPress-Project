<?php

namespace SureCart\Models\Traits;

use SureCart\Models\LineItem;

/**
 * If the model has an attached customer.
 */
trait HasLineItem {
	/**
	 * Set the line item attribute
	 *
	 * @param object $value Line item properties.
	 * @return void
	 */
	public function setLineItemAttribute( $value ) {
		$this->setRelation( 'line_item', $value, LineItem::class );
	}
}
