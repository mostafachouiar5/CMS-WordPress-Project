<?php

namespace SureCart\Models\Traits;

use SureCart\Models\Affiliation;

/**
 * If the model has an attached customer.
 */
trait HasAffiliation {
	/**
	 * Set the affiliation attribute
	 *
	 * @param object $value Array of payout objects.
	 *
	 * @return void
	 */
	public function setAffiliationAttribute( $value ) {
		$this->setRelation( 'affiliation', $value, Affiliation::class );
	}
}
