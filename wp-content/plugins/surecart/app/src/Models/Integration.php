<?php
namespace SureCart\Models;

use SureCart\Models\DatabaseModel;

/**
 * The integration model.
 */
class Integration extends DatabaseModel {
	/**
	 * The integrations table name.
	 *
	 * @var string
	 */
	protected $table_name = 'surecart_integrations';

	/**
	 * The object name
	 *
	 * @var string
	 */
	protected $object_name = 'integration';

	/**
	 * Fillable items.
	 *
	 * @var array
	 */
	protected $fillable = [ 'id', 'model_name', 'model_id', 'price_id', 'variant_id', 'integration_id', 'integration_slug', 'provider', 'integration_type', 'created_at', 'updated_at', 'deleted_at' ];
}
