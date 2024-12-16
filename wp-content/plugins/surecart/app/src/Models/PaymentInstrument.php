<?php
namespace SureCart\Models;

/**
 * Payment instrument model.
 */
class PaymentInstrument extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'payment_instruments';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'payment_instrument';

	/**
	 * Payment instrument types.
	 *
	 * @var string[]
	 */
	public function getTypes(): array {
		return [
			'card'         => __('Card', 'surecart'),
			'bank_account' => __('Bank Account', 'surecart'),
			'applepay'     => __('Apple Pay', 'surecart'),
			'bancontact'   => __('Bancontact', 'surecart'),
			'banktransfer' => __('Bank Transfer', 'surecart'),
			'belfius'      => __('Belfius', 'surecart'),
			'creditcard'   => __('Credit Card', 'surecart'),
			'directdebit'  => __('Direct Debit', 'surecart'),
			'eps'          => __('EPS', 'surecart'),
			'giftcard'     => __('Gift Card', 'surecart'),
			'giropay'      => __('Giropay', 'surecart'),
			'ideal'        => __('iDEAL', 'surecart'),
			'sepa_debit'   => __('SEPA Debit', 'surecart'),
			'in3'          => __('In3', 'surecart'),
			'kbc'          => __('KBC', 'surecart'),
			'klarna'       => __('Klarna', 'surecart'),
			'mybank'       => __('MyBank', 'surecart'),
			'paysafecard'  => __('Paysafecard', 'surecart'),
			'przelewy24'   => __('Przelewy24', 'surecart'),
			'sofort'       => __('Sofort', 'surecart'),
			'voucher'      => __('Voucher', 'surecart'),
		];
	}

	/**
	 * Get the payment instrument display name attribute.
	 *
	 * @return string
	 */
	public function getDisplayNameAttribute(): string {
		$type = $this->instrument_type ?? '';
		if ( empty( $type ) ) {
			return '';
		}

		return $this->getTypes()[ $type ] ?? ucfirst( $type );
	}
}
