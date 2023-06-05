<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Week;
use Illuminate\Support\Carbon;

class UserCSPTable
{
	public $tag = 'aspen_user_csp_table';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		$rows = [
			["Week Ending", "11/05", "11/12", "11/19", "11/26", "12/03", "12/10", "12/17", "12/24"],
			["CSPs Earned", 60, 12, 0, 24, 24, 12, 12, 12],
			["CMRs Completed", 5, 0, 0, 2, 2, 0, 0, 1],
			["TMRs Completed", 0, 3, 0, 0, 0, 3, 3, 0],
		];

		$rows = [
			 ["Week Ending"],
			 ["CSPs Earned"],
			 ["CMRs Completed"],
			 ["TMRs Completed"],
		];

		$weeks = Week::forLoggedInUser()->forCSPAverage()->get();

		foreach ($weeks as $week) {
			$week_end_date = Carbon::parse($week['week_start_date'])->endOfWeek();
			$rows[0][] = $week_end_date->format('m/d');
			$rows[1][] = $week->csps;
			$rows[2][] = $week->cmrs;
			$rows[3][] = $week->tmrs;
		}

		ob_start();
		include ASPEN_PLUGIN_DIR . '/templates/csp-table.php';
		return ob_get_clean();
	}
}
