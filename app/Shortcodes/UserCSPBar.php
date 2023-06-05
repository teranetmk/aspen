<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Week;

class UserCSPBar
{
	public $tag = 'aspen_user_csp_bar';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		$weeks = Week::forLoggedInUser()->forCSPAverage()->get();

		$avg = $weeks->count() > 0 ? round($weeks->avg('csps')) : 0;

		ob_start();

		echo '<div id="aspen-user-csp-bar" data-csp="' . $avg . '"></div>';

		return ob_get_clean();
	}
}
