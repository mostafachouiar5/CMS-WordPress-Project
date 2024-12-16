<?php

namespace SureCart\Models\Traits;

use SureCart\Models\PaymentInstrument;

/**
 * If the model has payment instrument.
 */
trait HasPaymentInstrument {
	/**
	 * Set the payment instrument attribute.
	 *
	 * @param  string $value Product properties.
	 * @return void
	 */
	public function setPaymentInstrumentAttribute( $value ) {
		$this->setRelation( 'payment_instrument', $value, PaymentInstrument::class );
	}

	/**
	 * Get the relation id attribute.
	 *
	 * @return string
	 */
	public function getPaymentInstrumentIdAttribute() {
		return $this->getRelationId( 'payment_instrument' );
	}
}
