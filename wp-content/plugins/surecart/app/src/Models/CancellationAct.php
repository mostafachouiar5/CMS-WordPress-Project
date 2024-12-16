<?php

namespace SureCart\Models;

use SureCart\Models\Traits\HasSubscription;

/**
 * Cancellation Reason Model
 */
class CancellationAct extends Model {
	use HasSubscription;

	/**
	 * Rest API endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'cancellation_acts';

	/**
	 * Object name
	 *
	 * @var string
	 */
	protected $object_name = 'cancellation_act';

	/**
	 * Set the cancellation_reason attribute
	 *
	 * @param  string $value Cancellation Reason properties.
	 * @return void
	 */
	public function setCancellationReasonAttribute( $value ) {
		$this->setRelation( 'cancellation_reason', $value, CancellationReason::class );
	}

	/**
	 * Get the relation id attribute
	 *
	 * @return string
	 */
	public function getCancellationReasonIdAttribute() {
		return $this->getRelationId( 'cancellation_reason' );
	}

	/**
	 * Get stats for the cancellation act.
	 *
	 * @param array $args Array of arguments for the statistics.
	 *
	 * @return \SureCart\Models\Statistic;
	 */
	protected function stats( $args = [] ) {
		$stat = new Statistic();
		return $stat->where( $args )->find( 'cancellation_acts' );
	}
}
