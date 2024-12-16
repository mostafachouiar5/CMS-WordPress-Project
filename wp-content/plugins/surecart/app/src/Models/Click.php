<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasAffiliation;

/**
 * Click model
 */
class Click extends Model {
	use HasAffiliation;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'clicks';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'click';

	/**
	 * Set the previous click
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setPreviousClickAttribute( $value ) {
		$this->setRelation( 'previous_click', $value, self::class );
	}
}
