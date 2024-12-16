<?php

namespace SureCart\Models\Traits;

use SureCart\Models\CommissionStructure;

/**
 * If the model has commission structure.
 */
trait HasCommissionStructure {
	/**
	 * Always set commission structure as object.
	 *
	 * @param array|object $value Value to set.
	 * @return void
	 */
	protected function setCommissionStructureAttribute( $value ) {
		$this->setRelation( 'commission_structure', (object) $value, CommissionStructure::class );
	}
}
