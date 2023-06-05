<?php

namespace Aspen;

use Aspen\Models\Calls;
use Aspen\Models\Contacts;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

class UserStatsQuery
{
	public $period;

	public $startDate;

	public $pharmacist_id;

	public $data_type;

	public function __construct($period, $pharmacist_id = 0, $data_type = null)
	{
		$this->period = $period;
		$this->pharmacist_id = $pharmacist_id; 
		$this->startDate = Carbon::today()->addDays(-1);
		$this->data_type = $data_type ?? 'cmr';
	}

	public function getData()
	{
		$calls = Calls::query()
			->where('pharmacist_id', $this->pharmacist_id)
			->forPeriod($this->period)
			->groupedForPeriod($this->period, $this->data_type)
			->get();
		$calls = $calls->pluck('y', 'x')->toArray();
		$calls = $this->fillMissingKeys($calls);

		$total = array_sum($calls);
		if ($this->period == 'yesterday') {
			$total = end($calls);
		}

		$contacts = Contacts::query()
			->where('pharmacist_id', $this->pharmacist_id)
			->forPeriod($this->period)
			->first();

		$last_updated = Carbon::parse($contacts->last_modified_date, wp_timezone());

		return [
			'dateRange' => $this->getTitle(),
			'period' => $this->period,
			'admin' => user_is_admin(),
			'last_updated' => $last_updated->format('M j, Y g:ia T'),
			'performance_title' => get_field('my_performance_title', 'options'),
			'performance_tooltip' => get_field('my_performance_tip', 'options'),
			'ncs_title' => get_field('my_ncs_title', 'options'),
			'ncs_tooltip' => get_field('my_ncs_tip', 'options'),
			'ncs_target' => get_field('ncs_target', 'options'),
			'apc_title' => get_field('my_apc_score_title', 'options'),
			'apc_tooltip' => get_field('my_apc_score_tip', 'options'),
			'apc_cmr_tooltip' => $this->getDynamicTooltip('apc', $contacts['apc_cmr']),
			'apc_tmr_tooltip' => $this->getDynamicTooltip('apc', $contacts['apc_tmr']),
			'ncs_cmr_tooltip' => $this->getDynamicTooltip('ncs', $contacts['ncs_cmr']),
			'ncs_tmr_tooltip' => $this->getDynamicTooltip('ncs', $contacts['ncs_tmr']),
			'stats' => [
				'cmr' => $contacts['cmr'] ?? 0,
				'tmr' => $contacts['tmr'] ?? 0,
				'medrec' => $contacts['medrec'] ?? 0,
				'ncs_score' => $contacts['ncs_score'] ?? 0,
				'apc_score' => $contacts['apc_score'] ?? 0,
				'apc_cmr' => $contacts['apc_cmr'] ?? 0,
				'apc_tmr' => $contacts['apc_tmr'] ?? 0,
				'ncs_cmr' => $contacts['ncs_cmr'] ?? 0,
				'ncs_tmr' => $contacts['ncs_tmr'] ?? 0,
				'calls' => $calls,
				'calls_labels' => array_keys($calls),
				'calls_values' => array_values($calls),
				// 'calls_bgs' => $this->backgrounds(),
				'total' => $total,
			],
		];
	}

	public function getTitle()
	{
		if ($this->period == 'year_to_date') {
			return Carbon::today()->format('Y');
		}

		if ($this->period == 'last_month') {
			return Carbon::today()->startOfMonth()->subMonth()->format('M Y');
		}

		if ($this->period == 'month_to_date') {
			return Carbon::today()->startOfMonth()->format('M Y');
		}

		if ($this->period == 'last_week') {
			$start = Carbon::today()->startOfWeek(Carbon::SUNDAY)->subWeek()->format('M d');
			$end = Carbon::today()->endOfWeek(Carbon::SATURDAY)->subWeek()->format('M d');
			return $start . ' - ' . $end;
		}

		if ($this->period == 'week_to_date') {
			$start = Carbon::today()->startOfWeek(Carbon::SUNDAY)->format('M d');
			$end = Carbon::today()->subDay()->format('M d');
			$end = max($start, $end);
			return $start . ' - ' . $end;
		}

		if ($this->period == 'yesterday') {
			return Carbon::today()->subDay()->format('M d');
		}
	}

	public function fillMissingKeys($data)
	{
		$new = [];

		if ($this->period == 'year_to_date') {
			$start = Carbon::today()->startOfYear();
			$datePeriod = CarbonPeriod::create($start, '1 month', 12);
			$fmt = 'M';
		}

		if ($this->period == 'last_month') {
			$start = Carbon::today()->startOfMonth()->subMonth();
			$datePeriod = CarbonPeriod::create($start, '1 day', $start->daysInMonth);
			$fmt = 'j';
		}

		if ($this->period == 'month_to_date') {
			$start = Carbon::today()->startOfMonth();
			$datePeriod = CarbonPeriod::create($start, '1 day', $start->daysInMonth);
			$fmt = 'j';
		}

		if ($this->period == 'last_week') {
			$start = Carbon::today()->startOfWeek(Carbon::SUNDAY)->subWeek();
			$datePeriod = CarbonPeriod::create($start, '1 day', 7);
			$fmt = 'D';
		}

		if ($this->period == 'week_to_date') {
			$start = Carbon::today()->startOfWeek(Carbon::SUNDAY)->subWeek();
			$datePeriod = CarbonPeriod::create($start, '1 day', 7);
			$fmt = 'D';
		}

		if ($this->period == 'yesterday') {
			$start = Carbon::today()->subWeek();
			$datePeriod = CarbonPeriod::create($start, '1 day', 7);
			$fmt = 'D';
		}

		foreach ($datePeriod as $p) {
			$key = $p->format($fmt);
			$new[$key] = $data[$key] ? (int)$data[$key] : null;
		}

		return $new;
	}

	public function backgrounds()
	{
		$backgrounds = [];

		$on = '#328fce';
		// $on = '#0068C9';
		$off = '#e9ebeb';

		if ($this->period == 'year_to_date') {
			$start = Carbon::today()->startOfYear();
			$datePeriod = CarbonPeriod::create($start, '1 month', 12);
			foreach ($datePeriod as $p) {
				// $backgrounds[] = $p->format('m') == Carbon::today()->format('m') ? $on : $off;
				$backgrounds[] = $on;
			}
		}

		if ($this->period == 'last_month') {
			$start = Carbon::today()->startOfMonth()->subMonth();
			$datePeriod = CarbonPeriod::create($start, '1 day', $start->daysInMonth);
			foreach ($datePeriod as $p) {
				// $backgrounds[] = $p->format('d') == $start->daysInMonth ? $on : $off;
				$backgrounds[] = $on;
			}
		}

		if ($this->period == 'month_to_date') {
			$start = Carbon::today()->startOfMonth();
			$datePeriod = CarbonPeriod::create($start, '1 day', $start->daysInMonth);
			foreach ($datePeriod as $p) {
				// $backgrounds[] = $p->format('d') == Carbon::today()->subDay()->format('d') ? $on : $off;
				$backgrounds[] = $on;
			}
		}

		if ($this->period == 'last_week') {
			$start = Carbon::today()->startOfWeek(Carbon::SUNDAY)->subWeek();
			$datePeriod = CarbonPeriod::create($start, '1 day', 7);
			foreach ($datePeriod as $p) {
				// $backgrounds[] = $p->format('d') == Carbon::today()->subDay()->format('d') ? $on : $off;
				$backgrounds[] = $on;
			}
		}

		if ($this->period == 'week_to_date') {
			$start = Carbon::today()->startOfWeek(Carbon::SUNDAY)->subWeek();
			$datePeriod = CarbonPeriod::create($start, '1 day', 7);
			foreach ($datePeriod as $p) {
				// $backgrounds[] = $p->format('d') == Carbon::today()->subDay()->format('d') ? $on : $off;
				$backgrounds[] = $on;
			}
		}

		if ($this->period == 'yesterday') {
			$start = Carbon::today()->subWeek();
			$datePeriod = CarbonPeriod::create($start, '1 day', 7);
			foreach ($datePeriod as $p) {
				$backgrounds[] = $p->format('d') == Carbon::today()->subDay()->format('d') ? $on : $off;
			}
		}

		return $backgrounds;
	}

	private function getDynamicTooltip($type, $score) {
		if ($score === 3) {
			return get_field("v3_{$type}_great", 'options');
		} elseif ($score === 2) {
			return get_field("v3_{$type}_middle", 'options');
		} elseif ($score === 1) {
			return get_field("v3_{$type}_poor", 'options');
		}

		return get_field("v3_{$type}_default", 'options');
	}
}
