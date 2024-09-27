<div class="setting-wrap">
    <h1 class="preloader-title"><?php _e('Preloader Setting', 'loadify-preloader'); ?></h1>
    <form action="#" method="post">
        <?php wp_nonce_field('ws_preloader_nonce_action', 'ws_preloader_nonce'); ?>
        <?php
        // Fetch the options data and handle the case where no data is available.
        $data = get_option('options_data');
        $decoded_data = json_decode($data);
        if (!$decoded_data) {
            $decoded_data = new stdClass();
        }

        // Initialize default values if they do not exist to avoid undefined property errors.
        if (!isset($decoded_data->font_text)) {
            $decoded_data->font_text = '';
        }
        if (!isset($decoded_data->font_size)) {
            $decoded_data->font_size = '16';
        }
        if (!isset($decoded_data->font_color)) {
            $decoded_data->font_color = '#000000';
        }
        if (!isset($decoded_data->preloader_bg)) {
            $decoded_data->preloader_bg = '#FFFFFF';
        }
        if (!isset($decoded_data->image_name)) {
            $decoded_data->image_name = WS_URL . "assets/img/default.png";
        }
        if (!isset($decoded_data->preloader_status)) {
            $decoded_data->preloader_status = '0';
        }
        if (!isset($decoded_data->pages_names)) {
            $decoded_data->pages_names = [];
        }
        if (!isset($decoded_data->selectdata)) {
            $decoded_data->selectdata = 'homepage';
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
                        <label class="label_style"><?php _e('Preloader Status', 'loadify-preloader'); ?></label>
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
                            <label><?php _e('Change Text', 'loadify-preloader'); ?></label>
                            <input type="text" name="font_text"
                                   value="<?php echo esc_attr($decoded_data->font_text); ?>"/>
                        </div>
                        <div class="field-item">
                            <label><?php _e('Font Size', 'loadify-preloader'); ?></label>
                            <input type="number" name="font_size"
                                   value="<?php echo esc_attr($decoded_data->font_size); ?>"/>
                        </div>
                        <div class="field-item">
                            <label><?php _e('Color', 'loadify-preloader'); ?></label>
                            <input type="color" name="font_color"
                                   value="<?php echo esc_attr($decoded_data->font_color); ?>"/>
                        </div>
                    </div>
                </div>
                <div id="tabs-4">
                    <div class="image-fields">
                        <label>
                            <input type="radio" name="image_name" value="<?php echo WS_URL . "assets/img/2.png"; ?>">
                            <img src="<?php echo WS_URL . "assets/img/2.png"; ?>" alt="Image 1">
                        </label>
                        <label>
                            <input type="radio" name="image_name" value="<?php echo WS_URL . "assets/img/3.png"; ?>">
                            <img src="<?php echo WS_URL . "assets/img/3.png"; ?>" alt="Image 2">
                        </label>
                        <label>
                            <input type="radio" name="image_name" value="<?php echo WS_URL . "assets/img/4.png"; ?>">
                            <img src="<?php echo WS_URL . "assets/img/4.png"; ?>" alt="Image 3">
                        </label>
                    </div>
                    <div class="image-fields flex-unset">
                        <h2><?php echo esc_html("Selected Image", 'loadify-preloader') ?></h2>
                        <img src="<?php echo $decoded_data->image_name; ?>" alt="No image selected">
                    </div>
                </div>
                <div id="tabs-5">
                    <div class="field-item">
                        <label class="label_style"><?php _e('Set Background', 'loadify-preloader'); ?></label>
                        <input type="color" name="preloader_bg"
                               value="<?php echo esc_attr($decoded_data->preloader_bg); ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
if (isset($_POST['submit']) && check_admin_referer('ws_preloader_nonce_action', 'ws_preloader_nonce')) {
    // Capture the form data
    $preloader_status = isset($_POST['preloader_status']) ? sanitize_text_field($_POST['preloader_status']) : '';
    $font_text = isset($_POST['font_text']) ? sanitize_text_field($_POST['font_text']) : '';
    $font_size = isset($_POST['font_size']) ? intval($_POST['font_size']) : '';
    $font_color = isset($_POST['font_color']) ? sanitize_hex_color($_POST['font_color']) : '';
    $preloader_bg = isset($_POST['preloader_bg']) ? sanitize_hex_color($_POST['preloader_bg']) : '';
    $image_name = isset($_POST['image_name']) ? esc_url_raw($_POST['image_name']) : '';
    $pages_names = isset($_POST['pages_names']) ? array_map('sanitize_text_field', $_POST['pages_names']) : [];
    $selectdata = isset($_POST['selectdata']) ? sanitize_text_field($_POST['selectdata']) : '';

    // Retrieve existing options from the database
    $existing_data = get_option('options_data');
    $options = json_decode($existing_data, true);
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
    $encoded_data = json_encode($options);
    update_option('options_data', $encoded_data);
}
?>
