<?php
/*
Plugin Name: WP Image Resizer & Optimizer
Description: Resize and optimize uploaded images automatically and manually
Version: 1.1
Author: natilos.ir
*/

class WP_Image_Resizer_Optimizer {
    private $options;

    public function __construct() {
        // Initialize plugin
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'settings_init']);
        add_filter('wp_handle_upload', [$this, 'process_uploaded_image']);

        // Load settings
        $this->options = get_option('wpiro_settings');
    }

    // Add admin menu
    public function add_admin_menu() {
        add_submenu_page('tools.php', 'Image Resizer & Optimizer', 'Image Resizer', 'manage_options', 'wp-image-resizer', [$this,
                                                                                                                           'admin_page']);
    }

    // Settings initialization
    public function settings_init() {
        register_setting('wpiro_settings', 'wpiro_settings');

        add_settings_section('wpiro_settings_section', 'Auto Resize & Optimize Settings', [$this,
                                                                                           'settings_section_callback'], 'wp-image-resizer');

        add_settings_field('max_width', 'Maximum Width (px)', [$this,
                                                               'max_width_render'], 'wp-image-resizer', 'wpiro_settings_section');

        add_settings_field('max_height', 'Maximum Height (px)', [$this,
                                                                 'max_height_render'], 'wp-image-resizer', 'wpiro_settings_section');

        add_settings_field('quality', 'Image Quality (1-100)', [$this,
                                                                'quality_render'], 'wp-image-resizer', 'wpiro_settings_section');

        add_settings_field('auto_resize', 'Auto Resize on Upload', [$this,
                                                                    'auto_resize_render'], 'wp-image-resizer', 'wpiro_settings_section');
    }

    // Settings fields rendering
    public function max_width_render() {
        $options = $this->options;
        ?>
        <input type="number" name="wpiro_settings[max_width]"
               value="<?php echo esc_attr($options['max_width'] ?? 1920); ?>" min="100">
        <?php
    }

    public function max_height_render() {
        $options = $this->options;
        ?>
        <input type="number" name="wpiro_settings[max_height]"
               value="<?php echo esc_attr($options['max_height'] ?? 1080); ?>" min="100">
        <?php
    }

    public function quality_render() {
        $options = $this->options;
        ?>
        <input type="number" name="wpiro_settings[quality]" value="<?php echo esc_attr($options['quality'] ?? 85); ?>"
               min="1" max="100">
        <?php
    }

    public function auto_resize_render() {
        $options = $this->options;
        ?>
        <input type="checkbox"
               name="wpiro_settings[auto_resize]" <?php checked(isset($options['auto_resize']) ? $options['auto_resize'] : false, true); ?>
               value="1">
        <?php
    }

    public function settings_section_callback() {
        echo 'Configure automatic image resizing and optimization settings';
    }

    // Admin page
    public function admin_page() {
        // Handle manual resize request
        if ( isset($_POST['resize_all_images']) ) {
            check_admin_referer('resize_all_action');
            $result = $this->resize_all_images();
            echo '<div class="notice notice-success"><p>Processed ' . $result['processed'] . ' images. ' . $result['skipped'] . ' images skipped.</p></div>';
        }

        ?>
        <div class="wrap">
            <h1>WP Image Resizer & Optimizer</h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('wpiro_settings');
                do_settings_sections('wp-image-resizer');
                submit_button();
                ?>
            </form>

            <hr>

            <h2>Manual Image Processing</h2>
            <form method="post">
                <?php wp_nonce_field('resize_all_action'); ?>
                <p>This will process all existing images in your media library.</p>
                <p><input type="submit" name="resize_all_images" class="button button-primary"
                          value="Process All Images"></p>
            </form>
        </div>
        <?php
    }

    // Process uploaded image
    public function process_uploaded_image( $file ) {
        if ( !isset($this->options['auto_resize']) || !$this->options['auto_resize'] ) {
            return $file;
        }

        // Check for all image types
        $image_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if ( in_array($file['type'], $image_types) ) {
            $this->resize_image($file['file'], $this->options['max_width'], $this->options['max_height'], $this->options['quality']);
        }

        return $file;
    }

    // Resize all images in media library
    public function resize_all_images() {
        $args = ['post_type'      => 'attachment',
                 'post_mime_type' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
                 'post_status'    => 'inherit',
                 'posts_per_page' => - 1,];

        $query     = new WP_Query($args);
        $processed = 0;
        $skipped   = 0;

        foreach ( $query->posts as $post ) {
            $file = get_attached_file($post->ID);

            if ( $file && file_exists($file) ) {
                $result = $this->resize_image($file, $this->options['max_width'], $this->options['max_height'], $this->options['quality']);

                if ( $result ) {
                    $processed ++;
                } else {
                    $skipped ++;
                }
            } else {
                $skipped ++;
            }
        }

        return ['processed' => $processed,
                'skipped'   => $skipped];
    }

    // Core image resizing function
    private function resize_image( $file_path, $max_width, $max_height, $quality ) {
        if ( !file_exists($file_path) ) {
            return false;
        }

        // Check if file is an image
        $image_info = @getimagesize($file_path);
        if ( !$image_info ) {
            return false;
        }

        $image_editor = wp_get_image_editor($file_path);

        if ( is_wp_error($image_editor) ) {
            return false;
        }

        $size   = $image_editor->get_size();
        $width  = $size['width'];
        $height = $size['height'];

        // Calculate new dimensions while maintaining aspect ratio
        $ratio = $width / $height;

        if ( $width > $max_width || $height > $max_height ) {
            if ( $width / $max_width > $height / $max_height ) {
                $new_width  = $max_width;
                $new_height = round($max_width / $ratio);
            } else {
                $new_height = $max_height;
                $new_width  = round($max_height * $ratio);
            }

            $image_editor->resize($new_width, $new_height, false);

            // Save with quality setting
            $image_editor->set_quality($quality);
            $saved = $image_editor->save($file_path);

            // Regenerate thumbnails
            if ( function_exists('wp_generate_attachment_metadata') ) {
                $attachment_id = attachment_url_to_postid(wp_get_attachment_url(basename($file_path)));
                if ( $attachment_id ) {
                    wp_generate_attachment_metadata($attachment_id, $file_path);
                }
            }

            return true;
        }

        return false;
    }
}

new WP_Image_Resizer_Optimizer();