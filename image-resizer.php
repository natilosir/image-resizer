<?php
/*
Plugin Name: ریسایزر عکس
Plugin URI: https://example.com/image-resizer
Description: یک پلاگین برای تغییر سایز عکس‌ها در وردپرس
Version: 1.0
Author: شما
Author URI: https://example.com
*/

// اطمینان از دسترسی مستقیم غیرمجاز
defined('ABSPATH') or die('دسترسی غیرمجاز!');



// اضافه کردن منوی مدیریت
add_action('admin_menu', 'image_resizer_admin_menu');

function image_resizer_admin_menu() {
    add_menu_page(
        'ریسایزر عکس', // عنوان صفحه
        'ریسایزر عکس', // عنوان منو
        'manage_options', // قابلیت مورد نیاز
        'image-resizer', // اسلاگ منو
        'image_resizer_admin_page', // تابع نمایش صفحه
        'dashicons-images-alt2', // آیکون
        80 // موقعیت در منو
    );
}







function image_resizer_admin_page() {
    ?>
    <div class="wrap">
        <h1>ریسایزر عکس</h1>

        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('image_resizer_action', 'image_resizer_nonce'); ?>

            <div>
                <label for="image_url">آدرس عکس:</label>
                <input type="text" name="image_url" id="image_url" style="width: 100%;">
                <p class="description">آدرس کامل عکس را وارد کنید یا از کتابخانه رسانه انتخاب کنید</p>
            </div>

            <div style="margin: 15px 0;">
                <label for="width">عرض (پیکسل):</label>
                <input type="number" name="width" id="width" min="1" value="800">

                <label for="height" style="margin-left: 15px;">ارتفاع (پیکسل):</label>
                <input type="number" name="height" id="height" min="1" value="600">
            </div>

            <div style="margin: 15px 0;">
                <label for="crop">برش تصویر:</label>
                <input type="checkbox" name="crop" id="crop" value="1">
            </div>

            <input type="submit" name="resize_image" class="button button-primary" value="تغییر سایز عکس">
        </form>

        <?php
        if (isset($_POST['resize_image'])) {
            image_resizer_process_image();
        }
        ?>
    </div>
    <?php
}






function image_resizer_process_image() {
    // بررسی nonce برای امنیت
    if (!isset($_POST['image_resizer_nonce']) ||
        !wp_verify_nonce($_POST['image_resizer_nonce'], 'image_resizer_action')) {
        wp_die('خطای امنیتی!');
    }

    // دریافت مقادیر فرم
    $image_url = esc_url_raw($_POST['image_url']);
    $width = intval($_POST['width']);
    $height = intval($_POST['height']);
    $crop = isset($_POST['crop']) ? true : false;

    // بررسی وجود فایل
    if (empty($image_url)) {
        echo '<div class="notice notice-error"><p>لطفا آدرس عکس را وارد کنید</p></div>';
        return;
    }

    // پردازش عکس
    $upload_dir = wp_upload_dir();
    $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);

    if (!file_exists($image_path)) {
        echo '<div class="notice notice-error"><p>عکس پیدا نشد!</p></div>';
        return;
    }

    // تغییر سایز عکس
    $resized_image = image_resizer_resize_image($image_path, $width, $height, $crop);

    if ($resized_image) {
        echo '<div class="notice notice-success"><p>عکس با موفقیت تغییر سایز شد!</p>';
        echo '<p><a href="' . esc_url($resized_image['url']) . '" target="_blank">نمایش عکس</a></p></div>';
    } else {
        echo '<div class="notice notice-error"><p>خطا در تغییر سایز عکس</p></div>';
    }
}





function image_resizer_resize_image($image_path, $width, $height, $crop = false) {
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $editor = wp_get_image_editor($image_path);

    if (is_wp_error($editor)) {
        return false;
    }

    // تغییر سایز
    $editor->resize($width, $height, $crop);

    // کیفیت تصویر
    $editor->set_quality(90);

    // تولید نام فایل جدید
    $info = pathinfo($image_path);
    $ext = $info['extension'];
    $filename = basename($image_path, ".$ext");
    $new_filename = $filename . '-' . $width . 'x' . $height . '.' . $ext;

    // ذخیره تصویر جدید
    $upload_dir = wp_upload_dir();
    $new_path = $upload_dir['path'] . '/' . $new_filename;
    $saved = $editor->save($new_path);

    if (is_wp_error($saved)) {
        return false;
    }

    // ایجاد attachment در وردپرس
    $attachment = array(
        'post_mime_type' => $saved['mime-type'],
        'post_title' => sanitize_file_name($new_filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $new_path);

    if ($attach_id) {
        $attach_data = wp_generate_attachment_metadata($attach_id, $new_path);
        wp_update_attachment_metadata($attach_id, $attach_data);

        return array(
            'id' => $attach_id,
            'path' => $new_path,
            'url' => $upload_dir['url'] . '/' . $new_filename
        );
    }

    return false;
}




// اضافه کردن اسکریپت‌ها و استایل‌ها
add_action('admin_enqueue_scripts', 'image_resizer_admin_scripts');

function image_resizer_admin_scripts($hook) {
    if ($hook != 'toplevel_page_image-resizer') {
        return;
    }

    // اضافه کردن مدیا آپلودر وردپرس
    wp_enqueue_media();

    // اسکریپت اختصاصی
    wp_enqueue_script('image-resizer-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), '1.0', true);

    // استایل
    wp_enqueue_style('image-resizer-style', plugin_dir_url(__FILE__) . 'css/style.css');
}






