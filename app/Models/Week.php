<?php

namespace Aspen\Models;

use Illuminate\Support\Carbon;

class Week extends BaseModel
{
	protected $connection = 'aspenrx';

	protected $table = 'pharmacist_weekly';

	public function scopeForCSPAverage($query) {
		$start = Carbon::today()->startOfWeek()->subWeeks(8);

		return $query->where('week_start_date', '>=', $start);
	}
}
