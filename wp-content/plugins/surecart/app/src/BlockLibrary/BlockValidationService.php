<?php

declare(strict_types=1);

namespace SureCart\BlockLibrary;

/**
 * Provide block validation functionality.
 */
class BlockValidationService {
	/**
	 * Block validators to register.
	 *
	 * @var array
	 */
	protected array $validators = [];

	/**
	 * Set validators
	 *
	 * @param array $validators Array of validators.
	 */
	public function __construct( $validators = [] ) {
		$this->validators = $validators;
	}

	/**
	 * Bootstrap the service.
	 *
	 * @return void
	 */
	public function bootstrap(): void {
		add_action( 'wp', [ $this, 'bootstrapValidators' ] );
	}

	/**
	 * Register block validators.
	 *
	 * @return void
	 */
	public function bootstrapValidators(): void {
		foreach ( $this->validators as $validator ) {
			$validator->bootstrap();
		}
	}
}
