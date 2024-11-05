<?php
/**
 * Plugin Name: Loadify-Preloader
 * Plugin URL: https://github.com/aburiad/Loadify-Preloader
 * Text Domain: loadify-preloader
 * Domain Path: /languages
 * Description: loadify-preloader : A loading screen add-on for your WordPress website.
 * Version: 1.0.0
 * Author: Riad
 * Author URI: https://github.com/aburiad
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 6.6
 */



if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!defined('loadifypreloader_DIR')) {
    define('loadifypreloader_DIR', dirname(__FILE__));
}
if (!defined('loadifypreloader_URL')) {
    define('loadifypreloader_URL', plugin_dir_url(__FILE__));
}

if (!defined('loadifypreloader_VERSION')) {
    define('loadifypreloader_VERSION', '1.0.0');
}

add_action('plugins_loaded', 'loadifypreloader_preloader_init',1);

function loadifypreloader_preloader_init() {
    require_once loadifypreloader_DIR . '/inc/admin/admin.php';
    require_once loadifypreloader_DIR . '/inc/public/frontend.php';

    new \loadifypreloader\loadifypreloaderAdmin();
    new \loadifypreloader\loadifypreloaderFrontend();
}






