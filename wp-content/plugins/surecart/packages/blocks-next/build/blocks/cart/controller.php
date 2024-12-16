<?php
$form      = \SureCart::forms()->getDefault();
$form_mode = \SureCart\Models\Form::getMode( $form->ID );
$style     = ! empty( $attributes['width'] ) ? 'width: ' . $attributes['width'] . ';' : '';

wp_interactivity_state(
	'surecart/checkout',
	array(
		// derived states.
		'checkout'             => [
			'line_items' => [
				'data' => [],
			],
		],
		'discountIsRedeemable' => false,
		'isDiscountApplied'    => false,
		'itemsCount'           => 0,
		'hasItems'             => false,
	)
);

return 'file:./view.php';
