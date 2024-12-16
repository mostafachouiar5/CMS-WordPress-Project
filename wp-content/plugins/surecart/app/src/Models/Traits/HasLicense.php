<?php

namespace SureCart\Models\Traits;

use SureCart\Models\License;

/**
 * If the model has an attached customer.
 */
trait HasLicense {
	/**
	 * Set the product attribute
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setLicenseAttribute( $value ) {
		$this->setRelation( 'license', $value, License::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getLicenseIdAttribute() {
		return $this->getRelationId( 'license' );
	}
}
