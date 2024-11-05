<?php

namespace loadifypreloader;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class loadifypreloaderFrontend
{
    public function __construct()
    {
        add_action('wp_body_open', array($this, 'loadifypreloader_render_preloader'));
        add_action('wp_enqueue_scripts', array($this, 'loadifypreloader_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'loadifypreloader_font_add')); // Set a priority to ensure this runs after styles
    }

    /**
     * Dynamically add Google Font and inline CSS for the preloader
     */
    function loadifypreloader_font_add()
    {
        // Get the serialized options data
        $data = get_option('loadifypreloader_data');
        $options = maybe_unserialize($data);

        // Retrieve the selected font or fallback to 'Roboto'
        $selected_font = isset($options['loadifypreloader_google_font']) ? $options['loadifypreloader_google_font'] : 'Roboto';

        // Add inline CSS for the preloader
        $inline_css = ".loadifypreloader-loader h2 { font-family: '" . esc_attr($selected_font) . "', sans-serif; }";
        wp_add_inline_style('loadifypreloader-preloader-css', $inline_css); // Attach to the preloader CSS
    }

    /**
     * Enqueue necessary scripts and styles, including the Google Font
     */
    public function loadifypreloader_scripts()
    {
        // Retrieve the options and check if preloader is active
        $data = get_option('loadifypreloader_data');
        $options = maybe_unserialize($data);
        $is_preloader_active = isset($options['preloader_status']) && $options['preloader_status'] === '1';
    
        if ($is_preloader_active) {
            // Retrieve the selected font from options or fallback to 'Roboto'
            $selected_font = isset($options['loadifypreloader_google_font']) ? $options['loadifypreloader_google_font'] : 'Roboto';
    
            // Enqueue Google Font
            $font_url = 'https://fonts.googleapis.com/css2?family=' . urlencode($selected_font) . '&display=swap';
            wp_enqueue_style('loadifypreloader_google_font', $font_url, array(), loadifypreloader_VERSION);
    
            // Enqueue preloader styles and scripts
            wp_enqueue_style('loadifypreloader-preloader-css', loadifypreloader_URL . '/assets/css/frontend.css', array(), loadifypreloader_VERSION, 'all');
            
            // Enqueue preloader JavaScript in the footer with defer
            wp_enqueue_script('loadifypreloader-preloader-js', loadifypreloader_URL . '/assets/js/ws-preloader.js', array('jquery'), loadifypreloader_VERSION, true);
            wp_script_add_data('loadifypreloader-preloader-js', 'defer', true);
        }
    }
    

    /**
     * Render the preloader HTML
     */
    public function loadifypreloader_render_preloader()
    {
        // Fetch saved options data
        $data = get_option('loadifypreloader_data');
        $options = maybe_unserialize($data);

        // Check if preloader should display
        if (!$this->loadifypreloader_get_display()) {
            return;
        }

        // Fetch settings
        $preloaderBg = isset($options['preloader_bg']) ? $options['preloader_bg'] : '#ffffff';
        $font_size = isset($options['font_size']) ? $options['font_size'] : '16';
        $font_color = isset($options['font_color']) ? $options['font_color'] : '#000000';
        $font_text = isset($options['font_text']) ? $options['font_text'] : '';
        $image_name = isset($options['image_name']) ? $options['image_name'] : '';

        ?>
        <div class="loadifypreloader-preloader" style="background-color: <?php echo esc_attr($preloaderBg); ?>;">
            <div class="loadifypreloader-loader">
                <?php if (empty($image_name)) { ?>
                    <h2 style="font-size:<?php echo esc_attr($font_size) . 'px'; ?>; color:<?php echo esc_attr($font_color); ?>">
                        <?php echo !empty($font_text) ? esc_html($font_text) : esc_html__('Loading...', 'loadify-preloader'); ?>
                    </h2>
                <?php } else { ?>
                    <img src="<?php echo esc_url($image_name); ?>" alt="Preloader Image">
                <?php } ?>
            </div>
        </div>

        <!--
        <div class="preloader">
            <div class="dot"></div>
        </div>

        <div class="dotscalepreloader">
          <div class="dotscale"></div>
          <div class="dotscale"></div>
          <div class="dotscale"></div>
          <div class="dotscale"></div>
        </div>
        -->
        <?php
    }

    /**
     * Determine if the preloader should be displayed based on page type
     */
    public function loadifypreloader_get_display()
    {
        // Fetch saved options data
        $data = get_option('loadifypreloader_data');
        $options = maybe_unserialize($data);

        // Get preloader status and current page setting
        $preloader_status = isset($options['preloader_status']) ? $options['preloader_status'] : '';
        $currentpage = isset($options['selectdata']) ? $options['selectdata'] : '';

        // Return false if preloader is not enabled
        if (empty($preloader_status)) {
            return false;
        }

        // Determine where the preloader should display
        switch ($currentpage) {
            case 'homepage':
                return is_home();
            case 'page':
                return is_page();
            case 'post':
                return is_single();
            case 'specefic':
                return is_page();
            case 'archive':
                return is_archive();
            case 'search':
                return is_search();
            case 'website':
                return true; // Display on entire website
            default:
                return false;
        }
    }

}
