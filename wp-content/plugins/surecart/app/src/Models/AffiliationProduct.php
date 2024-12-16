<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCommissionStructure;
use SureCart\Models\Traits\HasProduct;

/**
 * AffiliationProduct Model
 */
class AffiliationProduct extends Model {
	use HasCommissionStructure, HasProduct;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'affiliation_products';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'affiliation_product';
}
