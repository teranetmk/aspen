<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Contacts;

class UserTier
{
	public $tag = 'aspen_user_tier';

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

		return "<span style='color: var(--tier-{$tier})'>{$tier}</span>";
	}
}
