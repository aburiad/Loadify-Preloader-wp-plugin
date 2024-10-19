<?php
namespace loadifypreloader;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class loadifypreloaderAdmin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'loadifypreloader_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'loadifypreloader_admin_assets'));
    }

    // Add the settings page to the admin menu
    public function loadifypreloader_admin_menu()
    {
        add_menu_page(
            __('Preloader Setting', 'loadify-preloader'),  // Updated text domain
            'Preloader Setting',
            'manage_options',
            'loadify-preloader',
            array($this, 'loadifypreloader_setting')
        );
    }

    // Display the markup for the settings page
    public function loadifypreloader_setting()
    {
        require_once(loadifypreloader_DIR . "/inc/admin/markup.php"); // Use require_once for safety
    }

    // Load admin styles and scripts
    public function loadifypreloader_admin_assets()
    {
        wp_enqueue_style('loadifypreloader-admin-css', loadifypreloader_URL . '/assets/css/ws-preloader.css', array(), loadifypreloader_VERSION, 'all');
        wp_enqueue_style('loadifypreloader-frontend-css', loadifypreloader_URL . '/assets/css/frontend.css', array(), loadifypreloader_VERSION, 'all');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('loadifypreloader-admin-js', loadifypreloader_URL . '/assets/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), loadifypreloader_VERSION, true);
    }
}
