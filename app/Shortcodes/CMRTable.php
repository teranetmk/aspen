<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Contacts;
use DateTime;

class CMRTable
{
	public $tag = 'aspen_cmr_table';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode($atts)
	{
		ob_start();

		$data = $atts['data'] == 'tmr' ? 'tmr' : 'cmr';

		$this->update_scheduled_price($data);

		$base = get_field("last_weeks_{$data}_rate_price", 'option');
		$tiers = ['silver', 'gold', 'platinum'];
		$tier = strtolower(Contacts::forLoggedInUser()->value('alps_tier_status'));
		$tier = in_array($tier, $tiers) ? $tier : 'base';

		if (isset($_GET['test_tier']) && in_array($_GET['test_tier'], $tiers)) {
			$tier = $_GET['test_tier'];
		}

		$rows = [
			'base'     => $base,
			'silver'   => $base * 1.05,
			'gold'     => $base * 1.10,
			'platinum' => $base * 1.20,
		];

		include ASPEN_PLUGIN_DIR . '/templates/cmr-table.php';

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
