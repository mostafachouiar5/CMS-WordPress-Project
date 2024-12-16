<?php

namespace SureCart\Models;

/**
 * ReturnItem model.
 */
class ReturnItem extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'return_items';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'return_item';

	/**
	 * Set the return request attribute
	 *
	 * @param  object $value Return request properties.
	 * @return void
	 */
	public function setReturnRequestAttribute( $value ) {
		$this->setRelation( 'return_request', $value, ReturnRequest::class );
	}

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
