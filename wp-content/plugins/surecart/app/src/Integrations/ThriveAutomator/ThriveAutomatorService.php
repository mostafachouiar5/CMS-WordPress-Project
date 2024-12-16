<?php

namespace SureCart\Integrations\ThriveAutomator;

use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductIDDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\PreviousProductNameField;
use SureCart\Integrations\ThriveAutomator\DataObjects\ProductDataObject;
use SureCart\Integrations\ThriveAutomator\DataFields\ProductDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\ProductIDDataField;
use SureCart\Integrations\ThriveAutomator\DataFields\ProductNameDataField;
use SureCart\Integrations\ThriveAutomator\DataObjects\PreviousProductDataObject;
use SureCart\Integrations\ThriveAutomator\Triggers\PurchaseCreatedTrigger;
use SureCart\Integrations\ThriveAutomator\Triggers\PurchaseRevokedTrigger;
use SureCart\Integrations\ThriveAutomator\Triggers\PurchaseInvokedTrigger;
use SureCart\Integrations\ThriveAutomator\Triggers\PurchaseUpdatedTrigger;

/**
 * Bootstrap the Thrive Automator integration.
 */
class ThriveAutomatorService {
	/**
	 * Bootstrap
	 *
	 * @return void
	 */
	public function bootstrap() {
		if ( ! function_exists( 'thrive_automator_register_app' ) ) {
			return;
		}
		// app.
		thrive_automator_register_app( ThriveAutomatorApp::class );

		// data objects.
		thrive_automator_register_data_object( ProductDataObject::class );
		thrive_automator_register_data_object( PreviousProductDataObject::class );

		// data fields.
		thrive_automator_register_data_field( ProductNameDataField::class );
		thrive_automator_register_data_field( ProductIDDataField::class );
		thrive_automator_register_data_field( ProductDataField::class );
		// previous.
		thrive_automator_register_data_field( PreviousProductDataField::class );
		thrive_automator_register_data_field( PreviousProductIDDataField::class );
		thrive_automator_register_data_field( PreviousProductNameField::class );

		// triggers.
		thrive_automator_register_trigger( PurchaseCreatedTrigger::class );
		thrive_automator_register_trigger( PurchaseRevokedTrigger::class );
		thrive_automator_register_trigger( PurchaseUpdatedTrigger::class );
		thrive_automator_register_trigger( PurchaseInvokedTrigger::class );
	}

}
