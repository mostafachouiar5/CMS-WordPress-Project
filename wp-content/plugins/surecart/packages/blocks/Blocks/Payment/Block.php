<?php

namespace SureCartBlocks\Blocks\Payment;

use SureCart\Models\ManualPaymentMethod;
use SureCart\Models\Processor;
use SureCartBlocks\Blocks\BaseBlock;

/**
 * Checkout block
 */
class Block extends BaseBlock {
	/**
	 * Keep track of number of instances.
	 *
	 * @var integer
	 */
	public static $instance = 0;

	/**
	 * Block attributes.
	 *
	 * @var array
	 */
	public $attributes = [];

	/**
	 * Render the block
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content Post content.
	 *
	 * @return string
	 */
	public function render( $attributes, $content = '' ) {
		$this->attributes = $attributes;
		$mode             = $this->block->context['surecart/form/mode'] ?? 'live';

		$processors      = Processor::where( [ 'live_mode' => 'test' === $mode ? false : true ] )->get();
		$stripe          = $this->getProcessorByType( 'stripe', $processors ) ?? null;
		$payment_element = (bool) get_option( 'sc_stripe_payment_element', true );

		\SureCart::assets()->addComponentData(
			'sc-payment',
			'#sc-payment-' . (int) self::$instance,
			[
				'label'                  => $attributes['label'] ?? '',
				'disabledProcessorTypes' => $attributes['disabled_methods'] ?? [],
				'manualPaymentMethods'   => ManualPaymentMethod::where( [ 'archived' => false ] )->get() ?? [],
				'secureNotice'           => $attributes['secure_notice'] ?? '',
			]
		);

		ob_start();
		?>

		<sc-payment
			id="<?php echo esc_attr( 'sc-payment-' . (int) self::$instance ); ?>"
			class="<?php echo esc_attr( $attributes['className'] ?? '' ); ?>"
		>
			<?php if ( $payment_element ) : ?>
				<sc-stripe-payment-element slot="stripe"></sc-stripe-payment-element>
			<?php else : ?>
				<sc-stripe-element slot="stripe"></sc-stripe-element>
			<?php endif; ?>
		</sc-payment>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get the processor by type.
	 *
	 * @param string $type The processor type.
	 * @param array  $processors Array of processors.
	 *
	 * @return \SureCart/Models/Processor|null;
	 */
	protected function getProcessorByType( $type, $processors ) {
		if ( is_wp_error( $processors ) ) {
			return null;
		}

		$key = array_search( $type, array_column( (array) $processors, 'processor_type' ), true );
		if ( ! is_int( $key ) ) {
			return null;
		}
		return $processors[ $key ] ?? null;
	}
}
