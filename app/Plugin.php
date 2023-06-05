<?php

namespace Aspen;

use Aspen\Commands\AspenCommands;
use Aspen\Shortcodes\CMRTable;
use Aspen\Shortcodes\LoginForm;
use Aspen\Shortcodes\PayRatesTable;
use Aspen\Shortcodes\UserCSPAverage;
use Aspen\Shortcodes\UserCSPBar;
use Aspen\Shortcodes\UserCSPTable;
use Aspen\Shortcodes\UserRating;
use Aspen\Shortcodes\UserStats;
use Aspen\Shortcodes\UserStatsV3;
use Aspen\Shortcodes\UserStreak;
use Aspen\Shortcodes\UserTier;
use Aspen\Shortcodes\UserTierIcon;

class Plugin
{
	public function init()
	{
		DB::init();
		new CMRTable;
		new Login;
		new LoginForm;
		new PayRatesTable;
		new UserCSPAverage;
		new UserCSPBar;
		new UserCSPTable;
		new UserRating;
		new UserStats;
		new UserStatsV3;
		new UserStreak;
		new UserTier;
		new UserTierIcon;

		add_action('wp_head', [$this, 'header_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

		if (class_exists('WP_CLI')) {
			\WP_CLI::add_command('aspen', AspenCommands::class);
		}
	}

	public function header_scripts()
	{
		echo '<script>let ajax_url = "' . admin_url('admin-ajax.php') . '"</script>';
	}

	public function enqueue_scripts()
	{
		$asset_dir = ASPEN_PLUGIN_DIR . 'dist/assets/';
		$asset_url = ASPEN_PLUGIN_URL . 'dist/assets/';

		foreach (glob($asset_dir . '*') as $file) {
			if (preg_match('/index.*js/', $file)) {
				wp_enqueue_script( 'aspen-stats-js', $asset_url . basename($file), [], null, true );
			}
			if (preg_match('/index.*css/', $file)) {
				wp_enqueue_style( 'aspen-stats-css', $asset_url . basename($file), [], null, 'all' );
			}
		}
	}
}
