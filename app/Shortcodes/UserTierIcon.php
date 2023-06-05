<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Contacts;

class UserTierIcon
{
	public $tag = 'aspen_user_tier_icon';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode($atts)
	{
		$tiers = ['bronze', 'silver', 'gold', 'platinum'];
		$tier = strtolower(Contacts::forLoggedInUser()->value('alps_tier_status'));
		$tier = in_array($tier, $tiers) ? $tier : 'base';

		if (isset($atts['version']) && $atts['version'] == 3) {
			$tier = str_replace('base', 'bronze', $tier);
		}

		if (isset($_GET['test_tier']) && in_array($_GET['test_tier'], $tiers)) {
			$tier = $_GET['test_tier'];
		}

		if (isset($atts['version']) && $atts['version'] == 3) {
			$img = ASPEN_PLUGIN_URL . "assets/images/medal-{$tier}-v3.png";
		} else {
			$img = ASPEN_PLUGIN_URL . "assets/images/medal-{$tier}.png";
		}

		return "<img height='44' width='44' src='{$img}' alt='{$tier}' />";
	}
}
