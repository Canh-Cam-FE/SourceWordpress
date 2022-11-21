<?php

/**
 * Canhcam functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Canhcam
 */
/**
 * ADD theme option framework
 */
define('THEME_NAME', "CanhCamTheme");
define('THEME_HOME', esc_url(home_url('/')));
define('THEME_URI', get_template_directory_uri());
define('THEME_DIR', get_template_directory());
define('THEME_INC', THEME_DIR . '/inc');

if (!function_exists('canhcam_setup')) :
	function canhcam_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on canhcam, use a find and replace
		 * to change 'canhcam' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('canhcamtheme', get_template_directory() . '/languages');
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');
		// This theme uses wp_nav_menu() in one location.
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));
		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('canhcam_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));
		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
		// Add logo
		add_theme_support('custom-logo');
	}
endif;
add_action('after_setup_theme', 'canhcam_setup');

function add_css_admin_menu()
{
	if (is_user_logged_in()) {
?>
		<style>
			header {
				top: 32px !important;
			}
		</style>
<?php
	}
}
add_action('wp_head', 'add_css_admin_menu');

/**
 * Classic Editor.
 */
add_filter('use_block_editor_for_post', '__return_false');

/**
 * Open excerpt page
 */

add_post_type_support('page', 'excerpt');

/**
 * Force sub-category to use tempate parent
 */
?>