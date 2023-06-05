<?php

namespace Aspen\Models;

class Contacts extends BaseModel
{
	protected $connection = 'aspenrx';

	protected $table = 'contacts';

	public function scopeForPeriod($query, $period = null)
	{
		$period = $period ?: filter_var($_GET['period'], FILTER_SANITIZE_STRING);

		$periods = [
			'year_to_date',
			'last_month',
			'month_to_date',
			'last_week',
			'week_to_date',
			'yesterday',
		];

		$fields = [
			'cmr',
			'tmr',
			'medrec',
			'ncs_score',
			'apc_score',
		];

		if (in_array($period, $periods)) {
			foreach ($fields as $field) {
				$query->selectRaw("{$field}_{$period} as {$field}");
			}
		}

		$fields = [
			'apc_cmr',
			'apc_tmr',
			'ncs_cmr',
			'ncs_tmr',
		];

		if (in_array($period, $periods)) {
			if ($period == 'year_to_date') {
				$period = 'prior_year';
			} else {
				$period = str_replace('last', 'prior', $period);
			}

			foreach ($fields as $field) {
				$query->selectRaw("gauge_flag_{$field}_{$period} as {$field}");
			}
		}

		$query->addSelect('last_modified_date');
	}
}
