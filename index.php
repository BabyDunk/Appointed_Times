<?php
	
	/*
	Plugin Name:    Appointed Times
	Plugin URI:     https://appointedtimes.babydunk.co.uk/
	Description:    A small plugin to display Elohim Appointed Times
	Version:        1.0
	Author:         Chris Wilkinson
	Author URI:     https://www.babydunk.co.uk
	License:        GPL2
	License URI:    https://www.gnu.org/licenses/gpl-2.0.html
	*/
	
	if (!function_exists('add_action')){
		die('Sorry you can\'t access these files directly');
	}
	
	// Constants
	define('CMLW_AP_DIR', __DIR__.'/');
	define('CMLW_AP_URL', __FILE__.'/');
	
	
	// Paths
	include(CMLW_AP_DIR.'admin/functions.php');
	include(CMLW_AP_DIR.'front/functions.php');
	include(CMLW_AP_DIR.'front/enqueues.php');
	
	

	// Front Hooks
	add_action('wp_loaded', 'CMLW_load_styles_enqueues');
	add_action('wp_enqueue_scripts', 'CMLW_load_script_enqueues');
	
	
	// Admin Hooks
	
	// Ajax
	add_action('wp_ajax_nopriv_CMLW_ajaxUploadedObj', 'CMLW_ajaxUploadedObj');
	//add_action('wp_ajax_CMLW_ajaxUploadedObj', 'CMLW_ajaxUploadedObj');
	add_action('wp_ajax_nopriv_CMLW_ajaxGetObj', 'CMLW_ajaxGetObj');
	//add_action('wp_ajax_CMLW_ajaxGetObj', 'CMLW_ajaxGetObj');


	// Shortcodes
	add_shortcode('CMLW_AT_SHORTCODE', 'CMLW_makeShortCode');
	
	
	// Core
	register_activation_hook(__FILE__, 'CMLW_onActivationPlugin');
	register_uninstall_hook(__FILE__, 'CMLW_onUninstallPlugin');
	