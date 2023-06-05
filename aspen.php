<?php
/**
 * Plugin Name:       AspenRx Custom Functionality
 * Plugin URI:        https://www.neonrain.com
 * Description:       AspenRx Custom Functionality
 * Version:           1.0
 * Author:            Neonrain
 * Author URI:        https://www.neonrain.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

use Aspen\Models\Contacts;

define('ASPEN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ASPEN_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once ASPEN_PLUGIN_DIR . 'vendor/autoload.php';

(new \Aspen\Plugin)->init();

function user_is_admin() {
	return is_user_logged_in() && array_intersect(['administrator'], wp_get_current_user()->roles);
}

function pharmacist_name() {
	return Contacts::forLoggedInUser()->value('first_name');
}
