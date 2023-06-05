<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Contacts;
use DateTime;

class PayRatesTable
{
	public $tag = 'aspen_pay_rates_table';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		ob_start();

		$this->update_scheduled_price('cmr');
		$this->update_scheduled_price('tmr');

		$tiers = ['bronze', 'silver', 'gold', 'platinum'];
		$tier = strtolower(Contacts::forLoggedInUser()->value('alps_tier_status'));
		$tier = in_array($tier, $tiers) ? $tier : 'bronze';

		if (isset($_GET['test_tier']) && in_array($_GET['test_tier'], $tiers)) {
			$tier = $_GET['test_tier'];
		}

		$cmr_base = get_field("last_weeks_cmr_rate_price", 'option');
		$tmr_base = get_field("last_weeks_tmr_rate_price", 'option');

		$rows = [
			'bronze'   => ['cmr' => $cmr_base, 'tmr' => $tmr_base],
			'silver'   => ['cmr' => $cmr_base * 1.05, 'tmr' => $tmr_base * 1.05],
			'gold'     => ['cmr' => $cmr_base * 1.10, 'tmr' => $tmr_base * 1.10],
			'platinum' => ['cmr' => $cmr_base * 1.20, 'tmr' => $tmr_base * 1.20],
		];

		include ASPEN_PLUGIN_DIR . '/templates/pay-rates-table.php';

		return ob_get_clean();
	}

	function update_scheduled_price($data)
	{
		$rate = get_field("scheduled_{$data}_rate", 'options');
		$date = get_field("scheduled_{$data}_rate_date", 'options');

		if ($rate && $date) {
			$date = new DateTime($date, wp_timezone());
			$today = new DateTime(null, wp_timezone());

			if ($date <= $today) {
				update_field("last_weeks_{$data}_rate_price", $rate, 'option');
				delete_field("scheduled_{$data}_rate", 'option');
				delete_field("scheduled_{$data}_rate_date", 'option');
			}
		}
	}
}
