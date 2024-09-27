<?php

namespace loadifypreloader;

class Frontend
{
    public function __construct()
    {
        add_action('wp_body_open', array($this, 'render_preloader'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('ws-preloader-css', WS_URL . '/assets/css/frontend.css', array(), WS_VERSION, 'all');
        wp_enqueue_script('ws-preloader-js', WS_URL . '/assets/js/ws-preloader.js', array('jquery'), WS_VERSION, true);
    }

    public function render_preloader()
    {
        // Fetch saved options data
        $data = get_option('options_data');
        $decoded_data = json_decode($data);

        // If the preloader shouldn't display, exit
        if (!$this->get_display()) {
            return;
        }

        // Fetch settings, and ensure variables are properly handled
        $preloaderBg = isset($decoded_data->preloader_bg) ? $decoded_data->preloader_bg : '#ffffff';
        $font_size = isset($decoded_data->font_size) ? $decoded_data->font_size : '16';
        $font_color = isset($decoded_data->font_color) ? $decoded_data->font_color : '#000000';
        $font_text = isset($decoded_data->font_text) ? $decoded_data->font_text : '';
        $image_name = isset($decoded_data->image_name) ? $decoded_data->image_name : "";

        ?>
        <div class="preloader" style="background-color: <?php echo esc_attr($preloaderBg); ?>;">
            <div class="loader">
                <img src="<?php echo esc_url($image_name); ?>" alt="Preloader Image">
                <h2 style="font-size:<?php echo esc_attr($font_size) . 'px'; ?>; color:<?php echo esc_attr($font_color); ?>">
                    <?php
                    if (empty($font_text)) {
                        echo esc_html__('Loading...', 'loadify-preloader');
                    } else {
                        echo esc_html($font_text);
                    }
                    ?>
                </h2>
            </div>
        </div>
        <?php
    }

    public function get_display()
    {
        // Fetch saved options data
        $data = get_option('options_data');
        $decoded_data = json_decode($data);

        // Ensure the preloader status is set and valid
        $preloader_status = isset($decoded_data->preloader_status) ? $decoded_data->preloader_status : '';
        $currentpage = isset($decoded_data->selectdata) ? $decoded_data->selectdata : '';

        if (empty($preloader_status)) {
            return false;
        }

        // Check which page type the preloader should display on
        switch ($currentpage) {
            case 'homepage':
                return is_home();
            case 'page':
                return is_page();
            case 'post':
                return is_single();
            case 'archive':
                return is_archive();
            case 'search':
                return is_search();
            case 'website':
                return true; // Display on the entire website
            default:
                return false; // If no matching condition, do not display
        }
    }
}
