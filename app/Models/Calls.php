<?php

namespace Aspen\Models;

use Aspen\DB;
use Illuminate\Support\Carbon;

class Calls extends BaseModel
{
	protected $connection = 'aspenrx';

	protected $table = 'pharmacist_daily';

	public static function booted()
	{
		static::addGlobalScope('orderByDate', function ($query) {
			$query->orderBy('date', 'asc');
		});
	}

	public function scopeForPeriod($query, $period = null)
	{
		$period = $period ?: filter_var($_GET['period'], FILTER_SANITIZE_STRING);

		$opts = [
			'year_to_date' => [
				Carbon::today()->startOfYear(),
				Carbon::today()->subDay(),
			],
			'last_month' => [
				Carbon::today()->subMonth()->startOfMonth(),
				Carbon::today()->subMonth()->endOfMonth(),
			],
			'month_to_date' => [
				Carbon::today()->startOfMonth(),
				Carbon::today()->subDay(),
			],
			'last_week' => [
				Carbon::today()->startOfWeek(Carbon::SUNDAY)->subWeek(),
				Carbon::today()->endOfWeek(Carbon::SATURDAY)->subWeek()->addDay(1),
			],
			'week_to_date' => [
				Carbon::today()->startOfWeek(Carbon::SUNDAY),
				Carbon::today()->subDay(),
			],
			'yesterday' => [
				Carbon::today()->subDay(7),
				Carbon::today()->subDay(),
			],
		];

		if (isset($opts[$period])) {
			return $query->whereBetween('date', $opts[$period]);
		}
	}

	public function scopeGroupedForPeriod($query, $period = null, $data_type = null)
	{
		$period = $period ?: filter_var($_GET['period'], FILTER_SANITIZE_STRING);

		if ($data_type == 'tmr') {
			$data_type = 'tmrs';
		} else if ($data_type == 'cmr') {
			$data_type = 'cmrs';
		} else {
			$data_type = 'calls';
		}

		if ($period == 'year_to_date') {
			return $query->selectRaw("date_format(date, '%b') as x, sum({$data_type}) as y")
				->groupBy(DB::raw('MONTH(date)'))
				->orderBy('date', 'asc');
		}

		if ($period == 'last_month') {
			return $query->selectRaw("date_format(date, '%e') as x, sum({$data_type}) as y")
				->groupBy(DB::raw('DAYOFMONTH(date)'));
		}

		if ($period == 'month_to_date') {
			return $query->selectRaw("date_format(date, '%e') as x, sum({$data_type}) as y")
				->groupBy(DB::raw('DAYOFMONTH(date)'));
		}

		if ($period == 'last_week') {
			return $query->selectRaw("date_format(date, '%a') as x, sum({$data_type}) as y")
				->groupBy(DB::raw('DAYOFWEEK(date)'));
		}

		if ($period == 'week_to_date') {
			return $query->selectRaw("date_format(date, '%a') as x, sum({$data_type}) as y")
				->groupBy(DB::raw('DAYOFWEEK(date)'));
		}

		if ($period == 'yesterday') {
			return $query->selectRaw("date_format(date, '%a') as x, sum({$data_type}) as y")
				->groupBy('date');
		}
	}
}
