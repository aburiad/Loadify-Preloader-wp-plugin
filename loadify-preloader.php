<?php
/**
 * Plugin Name: Loadify-Preloader
 * Plugin URL: https://github.com/aburiad/Loadify-Preloader
 * Text Domain: loadify-preloader
 * Domain Path: /languages/
 * Description: ws-preloader : A loading screen add-on for your WordPress website.
 * Version: 1.0.0
 * Author: Riad
 * Author URI: https://github.com/aburiad
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!defined('WS_DIR')) {
    define('WS_DIR', dirname(__FILE__));
}
if (!defined('WS_URL')) {
    define('WS_URL', plugin_dir_url(__FILE__));
}

if (!defined('WS_VERSION')) {
    define('WS_VERSION', '1.0.0');
}

add_action('plugins_loaded', 'ws_preloader_init');

function ws_preloader_init() {
    require_once WS_DIR . '/inc/admin/admin.php';
    require_once WS_DIR . '/inc/public/frontend.php';

    new \loadifypreloader\Admin();
    new \loadifypreloader\Frontend();
}










