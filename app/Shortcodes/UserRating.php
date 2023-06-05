<?php

namespace Aspen\Shortcodes;

use Aspen\Models\Contacts;

class UserRating
{
	public $tag = 'aspen_user_rating';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		$rating = Contacts::forLoggedInUser()->value('pharmacist_rating');

		ob_start();
		include ASPEN_PLUGIN_DIR . '/templates/rating.php';
		return ob_get_clean();
	}
}
