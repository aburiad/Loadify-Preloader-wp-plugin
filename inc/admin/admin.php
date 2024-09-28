<?php

namespace loadifypreloader;

class Admin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'load_admin_assets'));
        add_action('admin_enqueue_scripts', array($this, 'my_plugin_enqueue_google_fonts'));
        add_action('wp_head', array($this, 'my_plugin_custom_css'));
    }
    function my_plugin_custom_css() {
        // Get the selected font
        $selected_font = get_option('my_plugin_google_font', 'Roboto'); // Default to 'Roboto' if none selected

        ?>
        <style type="text/css">
            .loader h2 {
                font-family: '<?php echo esc_html($selected_font); ?>', sans-serif;
            }
        </style>
        <?php
    }


    function my_plugin_enqueue_google_fonts()
    {
        // Get the selected font from options
        $selected_font = get_option('my_plugin_google_font', 'Roboto'); // Default to 'Roboto' if no font is selected

        // Build Google Fonts URL
        $font_url = 'https://fonts.googleapis.com/css?family=' . urlencode($selected_font);

        // Enqueue the Google Font
        wp_enqueue_style('my-plugin-google-font', $font_url, array(), null);
    }

    // Add the settings page to the admin menu
    public function admin_menu()
    {
        add_menu_page(
            __('Preloader Setting', 'loadify-preloader'),  // Updated text domain
            'Preloader Setting',
            'manage_options',
            'loadify-preloader',
            array($this, 'preloader_setting')
        );
    }

    // Display the markup for the settings page
    public function preloader_setting()
    {
        require_once(WS_DIR . "/inc/admin/markup.php"); // Use require_once for safety
    }

    // Load admin styles and scripts
    function load_admin_assets()
    {
        wp_enqueue_style('ws-admin-css', WS_URL . '/assets/css/ws-preloader.css', array(), WS_VERSION, 'all');
        wp_enqueue_style('ws-frontend-css', WS_URL . '/assets/css/frontend.css', array(), WS_VERSION, 'all');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('ws-admin-js', WS_URL . '/assets/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), WS_VERSION, true);
    }
}
