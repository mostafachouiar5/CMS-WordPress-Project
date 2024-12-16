<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasCommissionStructure;

/**
 * Holds the data of the current Affiliation protocol.
 */
class AffiliationProtocol extends Model {
	use HasCommissionStructure;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'affiliation_protocol';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'affiliation_protocol';
}
