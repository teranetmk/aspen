<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Week;

class UserCSPAverage
{
	public $tag = 'aspen_user_csp_average';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		$weeks = Week::forLoggedInUser()->forCSPAverage()->get();

		return $weeks->count() > 0 ? round($weeks->avg('csps')) : 0;
	}
}
