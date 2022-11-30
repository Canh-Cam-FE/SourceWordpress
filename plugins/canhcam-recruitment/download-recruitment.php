<?php

/**
 * Plugin Name: Cánh Cam Plugin - Module tuyển dụng
 * Plugin URI: https://canhcam.vn/
 * Description: Quản lý tuyển dụng
 * Version: 1.0.0
 * Author: Quang Nguyen
 * Author URI: https://canhcam.vn/
 * License: GPL v2 or later
 * Text Domain: download-recruiment-canh-cam
 */
/**
 * Custom field acf download career
 */
defined('ABSPATH') or die('No script kiddies please!');

if (!class_exists('canhcam_recruitment_plugin')) {
	class canhcam_recruitment_plugin
	{
		protected static $instance;
		public static function init()
		{
			is_null(self::$instance) and self::$instance = new self;
			return self::$instance;
		}
		public function __construct()
		{
			add_action('admin_notices', array($this, 'admin_notices_career'));
			add_action('admin_menu', array($this, 'custom_options_page_career'));
			add_action('init', array($this, 'career_custom_post_type'));
			add_action('init', array($this, 'create_taxonomy_category_careers'), 0);
			if (function_exists('acf_add_local_field_group')) :
				acf_add_local_field_group(array(
					'key' => 'group_635a5cdd039e8',
					'title' => 'Chi tiết tuyển dụng',
					'fields' => array(
						array(
							'key' => 'field_635a5cfa123fb',
							'label' => 'Thông tin công ty',
							'name' => 'company_infomation',
							'type' => 'group',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'layout' => 'row',
							'sub_fields' => array(
								array(
									'key' => 'field_635a5d12123fc',
									'label' => 'Logo',
									'name' => 'image',
									'type' => 'image',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'url',
									'preview_size' => 'medium',
									'library' => 'all',
									'min_width' => '',
									'min_height' => '',
									'min_size' => '',
									'max_width' => '',
									'max_height' => '',
									'max_size' => '',
									'mime_types' => '',
								),
								array(
									'key' => 'field_635a5d25123fd',
									'label' => 'Tiêu đề',
									'name' => 'title',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5d42123fe',
									'label' => 'Lương',
									'name' => 'salary',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5d43123ff',
									'label' => 'Hạn nộp',
									'name' => 'end_date',
									'type' => 'date_picker',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'display_format' => 'd.m.y',
									'return_format' => 'd.m.y',
									'first_day' => 1,
								),
								array(
									'key' => 'field_635a5d6e12400',
									'label' => 'Chức vụ',
									'name' => 'position',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a6099e07a3',
									'label' => 'Địa điểm',
									'name' => 'local',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a62340adeb',
									'label' => 'Thời gian',
									'name' => 'time',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
							),
						),
						array(
							'key' => 'field_635a5d8012401',
							'label' => 'Thông tin chi tiết',
							'name' => 'infomation_detail',
							'type' => 'group',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'layout' => 'block',
							'sub_fields' => array(
								array(
									'key' => 'field_635a5d9212402',
									'label' => 'Ngành nghề',
									'name' => 'job',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5dcb12403',
									'label' => 'Cấp bậc',
									'name' => 'level',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5dd012409',
									'label' => 'Giới tính',
									'name' => 'sex',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5dd012408',
									'label' => 'Yêu cầu kinh nghiệm',
									'name' => 'requirement',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5dcf12407',
									'label' => 'Lương',
									'name' => 'salary',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5dce12406',
									'label' => 'Trình độ văn hóa',
									'name' => 'level_culture',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635a5dcd12405',
									'label' => 'Trình độ chuyên môn',
									'name' => 'qualification',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_635b4be79c064',
									'label' => 'Link Form Ứng Tuyển',
									'name' => 'link_form_recruitment',
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
								),
							),
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'career',
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
		}
		function custom_options_page_career()
		{
			add_submenu_page(
				'edit.php?post_type=career',
				__('Cấu hình tuyển dụng', 'manage-career-canh-cam'),
				__('Cấu hình tuyển dụng', 'manage-career-canh-cam'),
				'manage_options',
				'settings-career.php',
				array($this, 'custom_career_settings'),
			);
		}
		function custom_career_settings()
		{
?>
	<div class="wrap">
		<h1><?php _e('Hướng dẫn sử dụng - ', 'download-career-canh-cam'); ?>Tuyển dụng</h1>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						Danh sách key get:
					</th>
					<td>
						<div style="background-color:white; border: 1px dashed black; padding: 15px; display: flex; gap: 15px;">
							<style>
								.table-border {
									border: 1px solid #d1d1d1;
									border-collapse: collapse;
								}

								.table-border td {
									padding: 7px 15px;
									border: 1px solid #d1d1d1;
								}
							</style>
							<table class="table-border">
								<tbody>
									<tr colspan="2">
										<td colspan="2">
											<span>
												Key group:
											</span>
											<strong>
												company_infomation
											</strong>
										</td>
									</tr>
									<tr>
										<td>
											Logo:
										</td>
										<td>
											image
										</td>
									</tr>
									<tr>
										<td>
											Tiêu đề:
										</td>
										<td>
											title
										</td>
									</tr>
									<tr>
										<td>
											Lương:
										</td>
										<td>
											salary
										</td>
									</tr>
									<tr>
										<td>
											Hạn nộp:
										</td>
										<td>
											end_date
										</td>
									</tr>
									<tr>
										<td>
											Chức vụ:
										</td>
										<td>
											position
										</td>
									</tr>
									<tr>
										<td>
											Địa điểm:
										</td>
										<td>
											local
										</td>
									</tr>
									<tr>
										<td>
											Thời gian:
										</td>
										<td>
											time
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table-border">
								<tbody>
									<tr colspan="2">
										<td colspan="2">
											<span>
												Key group:
											</span>
											<strong>
												infomation_detail
											</strong>
										</td>
									</tr>
									<tr>
										<td>
											Ngành nghề:
										</td>
										<td>
											job
										</td>
									</tr>
									<tr>
										<td>
											Cấp bậc:
										</td>
										<td>
											level
										</td>
									</tr>
									<tr>
										<td>
											Giới tính:
										</td>
										<td>
											sex
										</td>
									</tr>
									<tr>
										<td>
											Yêu cầu kinh nghiệm:
										</td>
										<td>
											requirement
										</td>
									</tr>
									<tr>
										<td>
											Lương:
										</td>
										<td>
											salary
										</td>
									</tr>
									<tr>
										<td>
											Trình độ văn hóa:
										</td>
										<td>
											level_culture
										</td>
									</tr>
									<tr>
										<td>
											Trình độ chuyên môn:
										</td>
										<td>
											qualification
										</td>
									</tr>
									<tr>
										<td>
											Link file ứng tuyển:
										</td>
										<td>
											link_form_recruitment
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
		}
		function career_custom_post_type()
		{
			$label = array(
				'name' => __('Tuyển dụng', 'canhcamtheme'), //Tên post type dạng số nhiều
				'singular_name' => __('Tuyển dụng', 'canhcamtheme'), //Tên post type dạng số ít
				'view_item' =>  __('Tuyển dụng', 'canhcamtheme'),
				'add_new_item' =>  __('Thêm Tuyển dụng', 'canhcamtheme'),
				'add_new' =>  __('Thêm Tuyển dụng', 'canhcamtheme'),
				'edit_item' => __('Chỉnh sửa Tuyển dụng', 'canhcamtheme'),
				'update_item' => __('Cập nhật', 'canhcamtheme'),
			);
			$args = array(
				'labels' => $label, //Gọi các label trong biến $label ở trên
				'description' => 'Tuyển dụng', //Mô tả của post type
				'supports' => array(
					'title',
					'editor',
					'thumbnail',
				), //Các tính năng được hỗ trợ trong post type
				'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
				'public' => true, //Kích hoạt post type
				'show_ui' => true, //Hiển thị khung quản trị như Post/Page
				'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
				'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
				'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
				'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
				'menu_icon' => 'dashicons-clipboard', //Đường dẫn tới icon sẽ hiển thị
				'can_export' => true, //Có thể export nội dung bằng Tools -> Export
				'rewrite' => array('slug' => 'tuyen-dung'),
				'has_archive' => false, //Cho phép lưu trữ (month, date, year)
				'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
				'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
				'capability_type' => 'post' //
			);
			register_post_type('career', $args); //Tạo post type với slug tên và các tham số trong biến $args ở trên
		}
		function create_taxonomy_category_careers()
		{
			$labels = array(
				'name'                       => _x('Danh sách tuyển dụng', 'Taxonomy General Name', 'canhcamthem'),
				'singular_name'              => _x('careers', 'Taxonomy Singular Name', 'canhcamtheme'),
				'menu_name'                  => __('Danh mục tuyển dụng', 'canhcamtheme'),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'rewrite'                    => array('hierarchical' => true, 'slug' => 'danh-sach-tuyen-dung'),
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
			);
			register_taxonomy('careers', array('career'), $args);
		}
		function admin_notices_career()
		{
			$class = 'notice notice-error';
			if (!function_exists('acf_add_local_field_group')) {
				printf('<div class="%1$s" style="margin: 20px 0px 15px 0px !important;"><p><strong>Plugin Cánh Cam Plugin - Module tuyển dụng:</strong> Hãy active plugin <strong>Advanced Custom Fields PRO</strong>. <a href="%2$s">Active tại đây</a></p></div>', esc_attr($class), esc_url(admin_url('wp-admin/plugins.php')));
			}
		}
	};
};
function canhcam_recruitment_plugin()
{
	return canhcam_recruitment_plugin::init();
}
canhcam_recruitment_plugin();
?>