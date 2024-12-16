<?php

namespace SureCart\Models;

/**
 * Price model
 */
class TaxProtocol extends Model {
	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'tax_protocol';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'tax_protocol';

	/**
	 * Does an update clear account cache?
	 *
	 * @var boolean
	 */
	protected $clears_account_cache = true;
}
