<?php
	/**
	 * Created by Chris Wilkinson.
	 * Title: appointed_times
	 * Date: 02/01/2019
	 * Time: 21:03
	 */
	
	function CMLW_load_script_enqueues(){
		
		wp_register_script(
			'CMLW_JAVASCRIPT',
			plugins_url('assets/js/script.js', CMLW_AP_URL),
			'',
			'1.0',
			true
		);
		wp_enqueue_script('CMLW_JAVASCRIPT');
		
	}
	
	function CMLW_load_styles_enqueues(){
		wp_register_style(
			'CMLW_styleSheet',
			plugins_url('assets/css/app.css', CMLW_AP_URL)
		);
		wp_enqueue_style('CMLW_styleSheet');
	}