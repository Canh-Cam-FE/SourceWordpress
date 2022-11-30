<?php

/**
 * Plugin Name: Cánh Cam Plugin - Module Tài Liệu
 * Plugin URI: https://canhcam.vn/
 * Description: Quản lý tài liệu
 * Version: 1.0.0
 * Author: Quang Nguyen
 * Author URI: https://canhcam.vn/
 * License: GPL v2 or later
 * Text Domain: download-document-canh-cam
 */
/**
 * Custom field acf download document
 */
defined('ABSPATH') or die('No script kiddies please!');

if (function_exists('acf_add_local_field_group')) :
	acf_add_local_field_group(array(
		'key' => 'group_635a04edcb819',
		'title' => 'Tài liệu đính kèm',
		'fields' => array(
			array(
				'key' => 'field_635a050e600b4',
				'label' => 'Chọn tài liệu đính kèm',
				'name' => 'upload_file',
				'type' => 'post_object',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'document',
				),
				'taxonomy' => '',
				'allow_null' => 0,
				'multiple' => 0,
				'return_format' => 'object',
				'translations' => 'copy_once',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));

	acf_add_local_field_group(array(
		'key' => 'group_6384433d8d139',
		'title' => 'Upload tài liệu',
		'fields' => array(
			array(
				'key' => 'field_63844348d3924',
				'label' => 'Chọn tài liệu',
				'name' => 'upload_document',
				'type' => 'file',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'library' => 'all',
				'min_size' => '',
				'max_size' => '',
				'mime_types' => '',
				'translations' => 'copy_once',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'document',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));

endif;

/**
 * Create post type document
 */

function document_custom_post_type()
{
	/*
* Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
*/
	$label = array(
		'name' => 'Tài liệu', //Tên post type dạng số nhiều
		'singular_name' => 'Tài liệu', //Tên post type dạng số ít
		'view_item' => 'Xem Tài liệu',
		'add_new_item' => 'Thêm Tài liệu Mới',
		'add_new' => 'Thêm Tài liệu',
		'edit_item' => 'Chỉnh sửa Tài liệu',
		'update_item' => 'Update Tài liệu',
	);
	/*
* Biến $args là những tham số quan trọng trong Post Type
*/
	$args = array(
		'labels' => $label, //Gọi các label trong biến $label ở trên
		'supports' => array(
			'title',
		), //Các tính năng được hỗ trợ trong post type
		'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
		'public' => true, //Kích hoạt post type
		'show_ui' => true, //Hiển thị khung quản trị như Post/Page
		'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
		'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
		'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
		'menu_position' => 4, //Thứ tự vị trí hiển thị trong menu (tay trái)
		'menu_icon' => 'dashicons-media-document', //Đường dẫn tới icon sẽ hiển thị
		'can_export' => true, //Có thể export nội dung bằng Tools -> Export
		'has_archive' => false, //Cho phép lưu trữ (month, date, year)
		'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
		'capability_type' => 'post' //
	);
	register_post_type('document', $args); //Tạo post type với slug tên và các tham số trong biến $args ở trên
}
add_action('init', 'document_custom_post_type');


/**
 * Add column count download
 */
// Add column
add_filter('manage_document_posts_columns', 'set_download_columns');
function set_download_columns($columns)
{
	$columns['donwload'] = __('Thống kê lượt tải', 'canhcamtheme');
	return $columns;
}



// Add data to column
add_action('manage_document_posts_custom_column', 'custom_data_download_column', 10, 2);
function custom_data_download_column($column, $post_id)
{
	switch ($column) {
		case 'donwload':
			$count = get_post_meta($post_id, 'wpb_document_download_count', true);
			if ($count) {
				echo $count;
			} else {
				_e('Chưa có tài liệu', 'download-document-canh-cam');
			}
			break;
	}
}

// Sort column
add_filter('manage_edit-document_sortable_columns', 'sort_column_download_document');

function sort_column_download_document($columns)
{
	$columns['donwload'] = 'donwload';

	return $columns;
}

function download_column_orderby($vars)
{
	if (isset($vars['orderby']) && 'donwload' == $vars['orderby']) {
		$vars = array_merge($vars, array(
			'meta_key' => 'wpb_document_download_count',
			'orderby' => 'meta_value_num'
		));
	}

	return $vars;
}
add_filter('request', 'download_column_orderby');

// Click add options download
function click_count_download_document()
{
	$count_key = 'wpb_document_download_count';
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
add_action('wp_ajax_click_count_download_document', 'click_count_download_document');
add_action('wp_ajax_nopriv_click_count_download_document', 'click_count_download_document');

/**
 * Add JS
 */

function add_ajax_document()
{
?>
	<script>
		if (!jQuery('.document-download-js').length > 0) return;
		jQuery('.document-download-js').on('click', function(e) {
			let post_id = jQuery(this).attr('data-post-id');
			var ajaxUrl = "<?php echo admin_url('admin-ajax.php') ?>";
			jQuery.ajax({
					url: ajaxUrl,
					data: {
						action: 'click_count_download_document',
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
		})
	</script>
<?php
} ?>
<?php add_action('wp_footer', 'add_ajax_document') ?>
<?php
add_action('admin_menu', 'custom_options_page');
function custom_options_page()
{
	add_submenu_page(
		'edit.php?post_type=document',
		__('Cấu hình tài Liệu', 'download-document-canh-cam'),
		__('Cấu hình tài Liệu', 'download-document-canh-cam'),
		'manage_options',
		'settings-document-download.php',
		'custom_document_download',
	);
}
function custom_document_download()
{
?>
	<div class="wrap ">
		<h1><?php _e('Hướng dẫn sử dụng - Module tài liệu', 'download-document-canh-cam'); ?></h1>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						Add class tracking download:
					</th>
					<td>
						<div style="background-color:white; border: 1px dashed black; padding: 15px">
							<?php echo esc_html('<a class="download-document-js" data-post-id="$id_document"></a>') ?>
						</div>
						<small>Add class download vào những thẻ a cần tracking</small>
						<br>
						<small><strong>Chú ý:</strong> id_document là id của tài liệu không phải id của post</small>
					</td>
				</tr>
				<tr>
					<th scope="row">
						Key field - chọn tài liệu:
					</th>
					<td>
						<div style="background-color:white; border: 1px dashed black; padding: 15px">
							$document = get_field('upload_file', get_the_ID());
							<br>
							$id_document = $document->ID;
							<br>
							$link_document = get_field('upload_document', $id_document);
						</div>
						<small><strong>Chú ý:</strong> get_the_ID() là id bài Post</small>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
}
?>
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