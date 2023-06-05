<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Contacts;

class UserStreak
{
	public $tag = 'aspen_user_streak';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		$threshold = 3;
		$streak = Contacts::forLoggedInUser()->value('week_streak') ?? 0;

		if (isset($_GET['test_streak'])) {
			$streak = $_GET['test_streak'];
		}

		ob_start();

		include ASPEN_PLUGIN_DIR . '/templates/user-streak.php';

		return ob_get_clean();
	}
}
