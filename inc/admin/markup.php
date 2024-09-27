<div class="setting-wrap">
    <h1 class="preloader-title"><?php echo esc_html(__('Preloader Setting', 'loadify-preloader')); ?></h1>
    <form action="#" method="post">
        <?php wp_nonce_field('ws_preloader_nonce_action', 'ws_preloader_nonce'); ?>
        <?php
        // Fetch the options data and handle the case where no data is available.
        $data = get_option('options_data');
        $options = maybe_unserialize($data);

        // If no data is available, initialize $options as an empty array
        if (!is_array($options)) {
            $options = [];
        }
        // Initialize default values if they do not exist to avoid undefined index errors.
        if (!isset($options['font_text'])) {
            $options['font_text'] = '';
        }
        if (!isset($options['font_size'])) {
            $options['font_size'] = '16';
        }
        if (!isset($options['font_color'])) {
            $options['font_color'] = '#000000';
        }
        if (!isset($options['preloader_bg'])) {
            $options['preloader_bg'] = '#FFFFFF';
        }
        if (!isset($options['image_name'])) {
            $options['image_name'] = WS_URL . "assets/img/default.png";
        }
        if (!isset($options['preloader_status'])) {
            $options['preloader_status'] = '0';
        }
        if (!isset($options['pages_names'])) {
            $options['pages_names'] = [];
        }
        if (!isset($options['selectdata'])) {
            $options['selectdata'] = 'homepage';
        }
        ?>

        <div id="tabs" class="tab-wrapper">
            <ul class="tab-list">
                <li><a href="#tabs-0">Preloader Status</a></li>
                <li><a href="#tabs-1">Preset</a></li>
                <li><a href="#tabs-2">Display</a></li>
                <li><a href="#tabs-3">Text</a></li>
                <li><a href="#tabs-4">Image</a></li>
                <li><a href="#tabs-5">Background</a></li>
                <input type="submit" name="submit" value="Submit"/>
            </ul>
            <div class="tab-content">
                <div id="tabs-0">
                    <div class="field-item">
                        <label class="label_style"><?php esc_html_e('Preloader Status', 'loadify-preloader'); ?></label>
                        <?php $selected = (get_option('preloader_status') == '1') ? 'checked' : ''; ?>
                        <input type="checkbox" name="preloader_status" value="1" <?php echo esc_attr($selected); ?> />
                    </div>
                </div>
                <div id="tabs-1">
                    <div class="field-item">
                        <h2><?php echo esc_html('Preset Comming', 'loadify-preloader') ?></h2>
                    </div>
                </div>
                <div id="tabs-2">
                    <div class="display-item">
                        <div>
                            <input type="radio" name="selectdata" value="homepage" id="homepage"
                                <?php checked(get_option('selectdata'), 'homepage'); ?> />
                            <label for="homepage">Home Page</label>
                        </div>
                        <div>
                            <input type="radio" name="selectdata" value="website" id="website"
                                <?php checked(get_option('selectdata'), 'website'); ?> />
                            <label for="website">Full Website</label>
                        </div>
                        <div>
                            <input type="radio" name="selectdata" value="post" id="post"/>
                            <label for="post">Post Only </label>
                        </div>
                        <div>
                            <input type="radio" name="selectdata" value="page" id="page"/>
                            <label for="page">Page Only </label>
                        </div>
                        <div>
                            <input type="radio" name="selectdata" value="archive" id="archive"/>
                            <label for="archive">Archive Only </label>
                        </div>
                        <div>
                            <input type="radio" name="selectdata" value="search" id="search"/>
                            <label for="search">Search Only </label>
                        </div>
                        <div>
                            <input type="radio" name="selectdata" value="specefic" id="specefic"/>
                            <label for="specefic">Specefic Only </label>
                            <div class="pages-item">
                                <?php
                                $pages = get_pages();
                                foreach ($pages as $page) {
                                    $checked = (in_array($page->post_title, (array)get_option('pages_names'))) ? 'checked' : '';
                                    ?>
                                    <label>
                                        <input type="checkbox" name="pages_names[]"
                                               value="<?php echo esc_attr($page->post_title); ?>" <?php echo esc_attr($checked); ?> />
                                        <span><?php echo esc_html($page->post_title); ?></span>
                                    </label>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs-3">
                    <div class="common-fields text-fields">
                        <div class="field-item">
                            <label><?php esc_html_e('Change Text', 'loadify-preloader'); ?></label>
                            <input type="text" name="font_text"
                                   value="<?php echo esc_attr($options['font_text']); ?>"/>
                        </div>
                        <div class="field-item">
                            <label><?php esc_html_e('Font Size', 'loadify-preloader'); ?></label>
                            <input type="number" name="font_size"
                                   value="<?php echo esc_attr($options['font_size']); ?>"/>
                        </div>
                        <div class="field-item">
                            <label><?php esc_html_e('Color', 'loadify-preloader'); ?></label>
                            <input type="color" name="font_color"
                                   value="<?php echo esc_attr($options['font_color']); ?>"/>
                        </div>
                    </div>
                </div>
                <div id="tabs-4">
                    <div class="image-fields">
                        <label>
                            <input type="radio" name="image_name" value="<?php echo esc_url(WS_URL . 'assets/img/2.png'); ?>">
                            <img src="<?php echo esc_url(WS_URL . 'assets/img/2.png'); ?>" alt="Image 1">
                        </label>

                        <label>
                            <input type="radio" name="image_name" value="<?php echo esc_url(WS_URL . 'assets/img/3.png'); ?>">
                            <img src="<?php echo esc_url(WS_URL . 'assets/img/3.png'); ?>" alt="Image 1">
                        </label>

                        <label>
                            <input type="radio" name="image_name" value="<?php echo esc_url(WS_URL . 'assets/img/4.png'); ?>">
                            <img src="<?php echo esc_url(WS_URL . 'assets/img/4.png'); ?>" alt="Image 1">
                        </label>

                    </div>
                    <div class="image-fields flex-unset">
                        <h2><?php echo esc_html__("Selected Image", 'loadify-preloader'); ?></h2>
                        <img src="<?php echo esc_url($options['image_name']); ?>" alt="No image selected">
                    </div>

                </div>
                <div id="tabs-5">
                    <div class="field-item">
                        <label class="label_style"><?php esc_html__('Set Background', 'loadify-preloader'); ?></label>
                        <input type="color" name="preloader_bg" value="<?php echo esc_attr($options['preloader_bg'] ?? '#ffffff'); ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
if (isset($_POST['submit']) && check_admin_referer('ws_preloader_nonce_action', 'ws_preloader_nonce')) {
    // Capture the form data
    $preloader_status = isset($_POST['preloader_status']) ? sanitize_text_field(wp_unslash($_POST['preloader_status'])) : '';
    $font_text = isset($_POST['font_text']) ? sanitize_text_field(wp_unslash($_POST['font_text'])) : '';
    $font_size = isset($_POST['font_size']) ? intval(wp_unslash($_POST['font_size'])) : '';
    $font_color = isset($_POST['font_color']) ? sanitize_hex_color(wp_unslash($_POST['font_color'])) : '';
    $preloader_bg = isset($_POST['preloader_bg']) ? sanitize_hex_color(wp_unslash($_POST['preloader_bg'])) : '';
    $image_name = isset($_POST['image_name']) ? esc_url_raw(wp_unslash($_POST['image_name'])) : '';
    $pages_names = isset($_POST['pages_names']) ? array_map('sanitize_text_field', wp_unslash($_POST['pages_names'])) : [];
    $selectdata = isset($_POST['selectdata']) ? sanitize_text_field(wp_unslash($_POST['selectdata'])) : '';

    // Retrieve existing options from the database
    $existing_data = get_option('options_data');
    $options = maybe_unserialize($existing_data); // Use maybe_unserialize instead of json_decode
    if (!is_array($options)) {
        $options = array();
    }

    // Update or add new options
    $options['preloader_status'] = $preloader_status;
    $options['font_text'] = $font_text;
    $options['font_size'] = $font_size;
    $options['font_color'] = $font_color;
    $options['preloader_bg'] = $preloader_bg;
    $options['image_name'] = $image_name;
    $options['pages_names'] = $pages_names;
    $options['selectdata'] = $selectdata;

    // Update the option in the database
    $encoded_data = serialize($options); // Use serialize instead of json_encode
    update_option('options_data', $encoded_data);
}
?>

