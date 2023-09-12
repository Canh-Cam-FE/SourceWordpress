<?php
//! Hiện view ở post type khác vui thì thay tất cả "post"->"custom-post-type"
/**
 * Plugin Name: Cánh Cam Plugin - Count View
 * Plugin URI: https://canhcam.vn/
 * Description: Đếm số lượt click bài viết
 * Version: 1.0.0
 * Author: Cánh Cam Dev
 * Author URI: https://canhcam.vn/
 * License: GPL v2 or later
 * Text Domain: count-view-canh-cam
 */
/**
 * Custom field acf download document
 */
defined('ABSPATH') or die('No script kiddies please!');


/**
 * Add column count download
 */
// Add column
add_filter('manage_shareholder_posts_columns', 'set_count_columns');
function set_count_columns($columns)
{
    $columns['views'] = __('Lượt xem', 'canhcamtheme');
    return $columns;
}



// Add data to column
add_action('manage_shareholder_posts_custom_column', 'custom_count_view_column', 10, 2);
function custom_count_view_column($column, $post_id)
{
    switch ($column) {
        case 'views':
            $count = get_post_meta($post_id, 'wpgn_count_view', true);
            if ($count) {
                echo '<div class="view-count" style="margin-bottom:.3rem">' . $count . '</div>';
            } else {
                echo '<div class="view-count" style="margin-bottom:.3rem">' . __('Chưa có lượt xem', 'download-document-canh-cam') . '</div>';
            }
            if (current_user_can('administrator')) {
?>
                <div class="view-edit button">Edit</div>
                <div class="view-count-wrapper" style="display:none">
                    <div class="view-count-container" style="display:flex; margin-top:.3rem;">
                        <input type="number" name="edit-view-count" style="width:100%" value="<?php echo esc_attr($count); ?>" data-post-id="<?php echo esc_attr($post_id); ?>" class="edit-view-count" />
                        <div class="save-view-count button">Save</div>
                    </div>
                </div>
        <?php
            }
            break;
    }
}

// Edit

function enqueue_inline_edit_script()
{
    wp_enqueue_script('inline-edit-script', get_stylesheet_directory_uri() . '/scripts/inline-edit-view.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'enqueue_inline_edit_script');


// Define the AJAX action
add_action('wp_ajax_update_view_count', 'update_view_count_callback');
add_action('wp_ajax_nopriv_update_view_count', 'update_view_count_callback');

// Callback function to update the view count
function update_view_count_callback()
{
    $post_id = intval($_POST['post_id']);
    $new_count = intval($_POST['new_count']);

    // Update the view count in the database
    update_post_meta($post_id, 'wpgn_count_view', $new_count);

    // Return the new count
    echo $new_count;
    exit();
}



// Sort column
add_filter('manage_edit-shareholder_sortable_columns', 'sort_column_views');

function sort_column_views($columns)
{
    $columns['views'] = 'views';

    return $columns;
}

function views_column_orderby($vars)
{
    if (isset($vars['orderby']) && 'views' == $vars['orderby']) {
        $vars = array_merge($vars, array(
            'meta_key' => 'wpgn_count_view',
            'orderby' => 'meta_value_num'
        ));
    }

    return $vars;
}
add_filter('request', 'views_column_orderby');

// Click add options download
function add_view_on_load()
{
    $count_key = 'wpgn_count_view';
    $post_id = !empty($_POST['post_id']) ? $_POST['post_id'] : '';
    $count = get_post_meta($post_id, $count_key, true);
    $count_original = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        $count = 1;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, $count);
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
    // echo $post_id . " - " . $count;
    echo $post_id . ' - ' . $count;
    die();
}
add_action('wp_ajax_add_view_on_load', 'add_view_on_load');
add_action('wp_ajax_nopriv_add_view_on_load', 'add_view_on_load');

/**
 * Add JS
 */

function add_ajax_document()
{
    if (is_singular('shareholder')) { // Only execute this function on single posts of the "post" post type
        global $post;
        ?>
        <script>
            window.addEventListener('load', function() {
                let post_id = "<?= $post->ID ?>";
                var ajaxUrl = "<?php echo admin_url('admin-ajax.php') ?>";
                jQuery.ajax({
                        url: ajaxUrl,
                        data: {
                            action: 'add_view_on_load',
                            post_id: post_id,
                        },
                        type: 'POST',
                    })
                    .done(function(data) {
                        console.log(`${data} - Add thành công`);
                    })
                    .fail(function(xhr) {
                        console.log(xhr);
                    })
            });
        </script>
<?php
    };
} ?>
<?php add_action('wp_footer', 'add_ajax_document') ?>

<?php
/**
 * Check Install ACF
 */
function admin_notices()
{
    $class = 'notice notice-error';
    if (!function_exists('acf_add_local_field_group')) {
        printf('<div class="%1$s" style="margin: 20px 0px 15px 0px !important;"><p><strong>Plugin Cánh Cam Plugin - Module Tài Liệu:</strong> Hãy active plugin <strong>Advanced Custom Fields PRO</strong>. <a href="%2$s">Active tại đây</a></p></div>', esc_attr($class), esc_url(admin_url('wp-admin/plugins.php')));
    }
}
add_action('admin_notices', 'admin_notices');

?>