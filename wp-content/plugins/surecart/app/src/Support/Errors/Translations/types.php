<?php
/**
 * Type translations
 *
 * @package SureCart
 */

return [
	'invalid_code'             => __( 'Invalid.', 'surecart' ),
	'invalid'                  => __( 'There were some validation errors.', 'surecart' ),
	'empty'                    => __( "Can't be empty.", 'surecart' ),
	'blank'                    => __( "Can't be blank.", 'surecart' ),
	'present'                  => __( 'Must be blank', 'surecart' ),
	'not_found'                => __( 'Not found.', 'surecart' ),
	'not_a_number'             => __( 'Not a number', 'surecart' ),
	'not_an_integer'           => __( 'Must be an integer', 'surecart' ),
	'model_invalid'            => __( 'Validation failed', 'surecart' ),
	'inclusion'                => __( 'This is not included in the list.', 'surecart' ),
	'exclusion'                => __( 'This is reserved.', 'surecart' ),
	'confirmation'             => __( "This doesn't match", 'surecart' ),
	'accepted'                 => __( 'Must be accepted.', 'surecart' ),
	'too_long'                 => __( 'Too long.', 'surecart' ),
	'too_short'                => __( 'Too short.', 'surecart' ),
	'greater_than'             => __( 'Must be larger.', 'surecart' ),
	'greater_than_or_equal_to' => __( 'Must be larger.', 'surecart' ),
	'less_than'                => __( 'Must be smaller.', 'surecart' ),
	'less_than_or_equal_to'    => __( 'Must be smaller.', 'surecart' ),
	'wrong_length'             => __( 'Wrong length.', 'surecart' ),
	'odd'                      => __( 'Must be odd', 'surecart' ),
	'even'                     => __( 'Must be even', 'surecart' ),
	'archived'                 => __( 'It is archived.', 'surecart' ),
	'currency_mismatch'        => __( 'It does not match parent currency.', 'surecart' ),
	'expired'                  => __( 'It is expired.', 'surecart' ),
	'invalid_processor'        => __( 'It is not valid or enabled.', 'surecart' ),
	'hex_color_format'         => __( 'It is not a valid hex color.', 'surecart' ),
	'multiple_active'          => __( 'Only one active abandoned checkout is allowed at a time', 'surecart' ),
	'send_after.too_soon'      => __( 'must be 15 minutes or more', 'surecart' ),
	'send_after.too_late'      => __( 'must be less than 1 week', 'surecart' ),
	'send_after.too_close'     => __( 'must be at least 12 hours between emails', 'surecart' ),
	'send_after.too_many'      => __( 'max count reached', 'surecart' ),
	'outside_range'            => __( 'This is outside the allowed amount.', 'surecart' ),
];


// en:
// activerecord:
// errors:
// messages:
// archived: "is archived"
// currency_mismatch: "does not match parent currency"
// expired: "is expired"
// invalid_processor: "not valid or enabled"
// hex_color_format: "is not a valid hex color"
// models:
// abandoned_order:
// attributes:
// customer:
// multiple_active: is only allowed one active abandoned checkout at a time
// abandonment_notification_template:
// attributes:
// send_after:
// too_soon: must be 15 minutes or more
// too_late: must be less than 1 week
// too_close: must be at least 12 hours between emails
// too_many: max count reached
// account_user:
// attributes:
// admin:
// cannot_be_removed: "role cannot be removed for the account owner"
// api_token:
// attributes:
// mode:
// not_enabled: "not enabled in this environment"
// order:
// paid_locked: "can't delete when status is 'paid'"
// attributes:
// line_items:
// stale_prices: one or more line items have stale price references
// coupon:
// conflicting_strategy: "only one of 'amount_off' or 'percent_off' can be set"
// discount:
// attributes:
// promotion:
// coupon_mismatch: "does not belong to coupon"
// promotion_code:
// invalid_code: "invalid code"
// line_item:
// attributes:
// ad_hoc_amount:
// outside_range: "must be between %{min} and %{max}"
// price:
// dependent_locked: "has dependent line items or subscriptions"
// attributes:
// ad_hoc:
// recurring: "can't be true when recurring is true"
// recurring_interval_count:
// max_interval: "must be less than or equal to 1 year"
// subscription_item:
// attributes:
// price:
// one_time: "must be recurring"
// webhook_endpoint:
// attributes:
// mode:
// not_enabled: "not enabled in this environment"
