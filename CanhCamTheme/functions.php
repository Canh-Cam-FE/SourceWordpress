<?php
define('GENERATE_VERSION', '1.1.0');
if (class_exists('CanhCam_Licsence_Class')) {
	require get_template_directory() . '/inc/function-root.php';
	require get_template_directory() . '/inc/function-custom.php';
	require get_template_directory() . '/inc/function-field.php';
	require get_template_directory() . '/inc/function-setup.php';
	require get_template_directory() . '/inc/function-pagination.php';
}
