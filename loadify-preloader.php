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
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 6.6
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

add_action('plugins_loaded', 'ws_preloader_init',1);

function ws_preloader_init() {
    require_once WS_DIR . '/inc/admin/admin.php';
    require_once WS_DIR . '/inc/public/frontend.php';

    new \loadifypreloader\Admin();
    new \loadifypreloader\Frontend();
}

function my_plugin_enqueue_google_fonts() {
    // Get the selected font from options
    $selected_font = get_option('my_plugin_google_font', 'Roboto'); // Default to 'Roboto' if no font is selected

    // Build Google Fonts URL
    $font_url = 'https://fonts.googleapis.com/css?family=' . urlencode($selected_font);

    // Enqueue the Google Font
    wp_enqueue_style('my-plugin-google-font', $font_url, array(), null);
}
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_google_fonts');









