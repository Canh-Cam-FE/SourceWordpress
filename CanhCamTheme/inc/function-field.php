<?php
function add_field_banner()
{
	acf_add_local_field_group(array(
		'key' => 'banner',
		'title' => 'Banner: Select Page',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'banner',
				),
			),
		),
	));
	acf_add_local_field(array(
		'key' => 'banner_select_page',
		'label' => 'Chọn trang hiển thị',
		'name' => 'Chọn trang hiển thị',
		'type' => 'post_object',
		'post_type' => 'page',
		'parent' => 'banner',
		'return_format' => 'id',
	));
}
add_action('acf/init', 'add_field_banner');
// Custom field class for page
function add_field_custom_class_body()
{
	acf_add_local_field_group(array(
		'key' => 'class_body',
		'title' => 'Body: Add Class',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
	));
	acf_add_local_field(array(
		'key' => 'add_class_body',
		'label' => 'Add class body',
		'name' => 'Add class body',
		'type' => 'text',
		'parent' => 'class_body',
	));
}
add_action('acf/init', 'add_field_custom_class_body');
