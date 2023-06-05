<?php

namespace Aspen\Shortcodes;

class LoginForm
{
	public $tag = 'aspen_login_form';

	public function __construct()
	{
		add_shortcode($this->tag, [$this, 'shortcode']);
	}

	public function shortcode()
	{
		ob_start();

		include ASPEN_PLUGIN_DIR . '/templates/login-form.php';

		return ob_get_clean();
	}
}
