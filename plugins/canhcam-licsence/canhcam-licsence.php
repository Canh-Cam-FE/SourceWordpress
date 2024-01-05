<?php
/*
* Plugin Name: Canhcam - Licsence
* Version: 1.0.8
* Description: Licsence
* Author: Cánh cam
* Author URI: https://canhcam.com
* Text Domain: canhcam-licsence
* Domain Path: /languages
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0

Canhcam - licsence
Copyright (C) 2023 Canh cam - https://canhcam.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
defined('ABSPATH') or die('No script kiddies please!');
if (!class_exists('CanhCam_Licsence_Class')) {
	add_action('plugins_loaded', array('CanhCam_Licsence_Class', 'init'));
	class CanhCam_Licsence_Class
	{
		protected static $instance;
		public $_optionName = 'canhcam_options';
		public $_optionGroup = 'canhcam-options-group';
		public $_defaultOptions = array(
			'active_licsence' 	=>	'',
			'active_time_licsence' 	=>	'',
		);
		public $_version = '1.0.0';
		public static function init()
		{
			is_null(self::$instance) and self::$instance = new self;
			return self::$instance;
		}
		public function __construct()
		{
			$this->define_constants();
			global $canhcam_settings;
			$canhcam_settings  = $this->get_dvlsoptions();
			add_action('wp_footer', array($this, 'canhcam_add_notify_trial'), 100);
			add_action('admin_notices', array($this, 'admin_notices_career'));
			add_action('admin_menu', array($this, 'createSettingLicsence'));
			add_action('admin_init', array($this, 'register_settings'));
			add_action('admin_menu', array($this, 'hidden_all_post_types'));
			add_action('rest_api_init', function () {
				register_rest_route('licsence/api', '/active', array(
					'methods' => 'POST',
					'callback' => array($this, 'active_licsence_api'),
				));
			});
		}
		function active_licsence_api($req)
		{
			$request_data = file_get_contents('php://input');
			$data = json_decode($request_data);
			$current_time = current_time('timestamp');
			$option_value = array('active_licsence' => $data->active_license, 'active_time_licsence' => $current_time);
			// Update the option in the database
			$update_result = update_option($this->_optionName, $option_value);
			// Return a response to the API request
			if ($update_result) {
				wp_send_json_success(array('message' => 'Option updated successfully'));
			} else {
				wp_send_json_error(array('message' => 'Option update failed'));
			}
		}
		public function define_constants()
		{
			if (!defined('CANHCAM_PLUGIN_DIR'))
				define('CANHCAM_PLUGIN_DIR', plugin_dir_path(__FILE__));
		}

		function get_dvlsoptions()
		{
			return wp_parse_args(get_option($this->_optionName), $this->_defaultOptions);
		}
		//
		function createSettingLicsence()
		{
			add_menu_page('Setting Trial - Canh cam', 'Setting Trial - Canh cam', 'manage_options', 'canh-cam-setting-trial', array($this, 'createSettingLicsence_callback'), null, 99);
			remove_menu_page('canh-cam-setting-trial');
		}
		function register_settings()
		{
			register_setting($this->_optionGroup, $this->_optionName);
		}
		function createSettingLicsence_callback()
		{
			include CANHCAM_PLUGIN_DIR . 'canhcam-settings.php';
		}
		//
		function calculateElapsedTime($startDateTime)
		{
			$now = time();
			$diff = $now - $startDateTime;
			$d = floor($diff / (24 * 60 * 60));
			$diff -= $d * 24 * 60 * 60;
			$h = floor($diff / (60 * 60));
			$diff -= $h * 60 * 60;
			$m = floor($diff / 60);
			$diff -= $m * 60;
			$s = $diff;
			if ($d > 0) {
				$elapsedTime = $d . " Ngày";
			} elseif ($h > 0) {
				$elapsedTime = $h . " Giờ " . $m . " Phút";
			} elseif ($m > 0) {
				$elapsedTime = $m . " Phút " . $s . " Giây";
			} else {
				$elapsedTime = $s . " Giây";
			}
			return $elapsedTime;
		}
		function getDateExpiration()
		{
			global $canhcam_settings;
			$current_time = current_time('timestamp');
			$activation_time = get_option('canhcam_licsence_activation_time');
			$expiration_time = strtotime('0 days', $canhcam_settings['active_time_licsence']);
			$overdue_time_format = $this->calculateElapsedTime($expiration_time);
			$expiration_time_format = date('d-m-Y H:i:s', $expiration_time);
			return ['expiration_time' => $expiration_time, 'expiration_time_format' => $expiration_time_format, 'overdue_time_format' => $overdue_time_format, 'activation_time' => $activation_time];
		}
		function isDateExpiration()
		{
			global $canhcam_settings;
			// ['current' => $current_time] = $this->formatTimeZoneVN(0);
			// ['expiration_time' => $expiration_time] = $this->getDateExpiration();
			$active_licsence = filter_var($canhcam_settings['active_licsence'], FILTER_VALIDATE_BOOLEAN);
			$result = !$active_licsence ? true : false;
			return $result;
		}
		function canhcam_add_notify_trial()
		{
			['expiration_time' => $expiration_time] = $this->getDateExpiration();
			$expiration_time_format = date('Y-m-d H:i:s', $expiration_time);
			['expiration_time' => $expiration_time, 'overdue_time_format' => $overdue_time_format] = $this->getDateExpiration();
			$isDateExpiration = $this->isDateExpiration();

			if ($isDateExpiration) {
				echo '<div style="position: fixed; bottom: 0; left: 0; width: 100%; padding: .6rem 0;background-color: #f73936; z-index: 99999999; text-align:center; color: white; font-size: 1rem; text-transform: uppercase">Demo version is expired. Phiên bản website đã hết hạn dùng thử</div>';
				echo $expiration_time;
			}
		}
		function formatTimeZoneVN($time)
		{
			$current_time = current_time('timestamp', true) + (7 * 3600);
			$time_gmt7 = $time + (7 * 3600);
			$format_time  = date('d-m-Y H:i:s', $time_gmt7);
			return ['current' => $current_time, 'time' => $time_gmt7, 'format' => $format_time];
		}
		function admin_notices_career()
		{
			global $canhcam_settings;
			$class = 'notice notice-error';
			['expiration_time_format' => $expiration_time_format, 'overdue_time_format' => $overdue_time_format, 'expiration_time' => $expiration_time] = $this->getDateExpiration();
			$isDateExpiration = $this->isDateExpiration();
			if ($isDateExpiration) {
				printf('<div class="%1$s" style="margin: 20px 0px 15px 0px !important;background-color: #f73936; color: white; text-transform: uppercase; font-weight: bold"><p style="font-size: 18px"><strong>Website đã quá hạn thanh toán: </strong>' . $overdue_time_format . '</strong> (Website của bạn đang bị giới hạn chức năng)</p></div>', esc_attr($class), esc_url(admin_url('wp-admin/plugins.php')));
			}
		}
		function hidden_all_post_types()
		{
			$idDateExpiration = $this->isDateExpiration();
			if ($idDateExpiration) {
				$post_types = get_post_types();
				$post_types_slice = array_slice($post_types, -5);
				foreach ($post_types_slice as $post_type) {
					remove_menu_page('edit.php?post_type=' . $post_type);
				}
				remove_menu_page('rank-math');
				remove_menu_page('edit.php');
			}
		}
	}
}
function canhcam_licsence_activation_hook()
{
	$current_time = current_time('timestamp');
	$option_value = array('active_licsence' => 'false', 'active_time_licsence' => $current_time);
	update_option('canhcam_options', $option_value);
}
register_activation_hook(__FILE__, 'canhcam_licsence_activation_hook');
