<?php

namespace Aspen\Shortcodes;

use Aspen\UserStatsQuery;
use Illuminate\Support\Carbon;

class UserStats
{
	public $tag = 'aspen_user_stats';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
		add_action('wp_ajax_user_stats', [$this, 'user_stats_ajax']);
	}

	public function shortcode()
	{
		return '<div id="aspen-user-stats"></div>';
	}

	public function user_stats_ajax()
	{
		if (!is_user_logged_in()) return;

		$period = filter_var($_GET['period'], FILTER_SANITIZE_STRING) ?: 'year_to_date';

		if (user_is_admin()) {
			$mock_date = filter_var($_GET['mock_date'], FILTER_SANITIZE_STRING);
			if ($mock_date) {
				Carbon::setTestNow($mock_date);
			}
			$pharmacist_id = $_GET['pharmacist_id'] ?? 0;
		} else {
			$pharmacist_id = get_user_meta(get_current_user_id(), 'pharmacist_id', true) ?: 0;
		}

		$query = new UserStatsQuery($period, $pharmacist_id);

		wp_send_json($query->getData());
	}
}
