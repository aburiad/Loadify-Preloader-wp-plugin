<?php
namespace loadifypreloader;

class Frontend
{
    public function __construct()
    {
        add_action('wp_body_open', array($this, 'render_preloader'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_head', array($this, 'preloader_font_add')); // Add inline CSS to wp_head
    }

    /**
     * Dynamically add Google Font and inline CSS for the preloader
     */
    function preloader_font_add() {
        // Get the serialized options data
        $data = get_option('options_data');
        $options = maybe_unserialize($data);

        // Retrieve the selected font or fallback to 'Roboto'
        $selected_font = isset($options['preloader_google_font']) ? $options['preloader_google_font'] : 'Roboto';

        ?>
        <style type="text/css">
            .loader h2 {
                font-family: '<?php echo esc_html($selected_font); ?>', sans-serif;
            }
        </style>
        <?php
    }

    /**
     * Enqueue necessary scripts and styles, including the Google Font
     */
    public function enqueue_scripts()
    {
        // Retrieve the selected font from options or fallback to 'Roboto'
        $data = get_option('options_data');
        $options = maybe_unserialize($data);
        $selected_font = isset($options['preloader_google_font']) ? $options['preloader_google_font'] : 'Roboto';

        // Enqueue Google Font
        $font_url = 'https://fonts.googleapis.com/css?family=' . urlencode($selected_font) . '&display=swap';
        wp_enqueue_style('my-plugin-google-font', $font_url, array(), null);

        // Enqueue preloader styles and scripts
        wp_enqueue_style('ws-preloader-css', WS_URL . '/assets/css/frontend.css', array(), WS_VERSION, 'all');
        wp_enqueue_script('ws-preloader-js', WS_URL . '/assets/js/ws-preloader.js', array('jquery'), WS_VERSION, true);
    }

    /**
     * Render the preloader HTML
     */
    public function render_preloader()
    {
        // Fetch saved options data
        $data = get_option('options_data');
        $options = maybe_unserialize($data);

        // Check if preloader should display
        if (!$this->get_display()) {
            return;
        }

        // Fetch settings
        $preloaderBg = isset($options['preloader_bg']) ? $options['preloader_bg'] : '#ffffff';
        $font_size = isset($options['font_size']) ? $options['font_size'] : '16';
        $font_color = isset($options['font_color']) ? $options['font_color'] : '#000000';
        $font_text = isset($options['font_text']) ? $options['font_text'] : '';
        $image_name = isset($options['image_name']) ? $options['image_name'] : '';

        ?>
        <div class="preloader" style="background-color: <?php echo esc_attr($preloaderBg); ?>;">
            <div class="loader">
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
        -->
        <?php
    }

    /**
     * Determine if the preloader should be displayed based on page type
     */
    public function get_display()
    {
        // Fetch saved options data
        $data = get_option('options_data');
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
