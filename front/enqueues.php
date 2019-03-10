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
		
		
		wp_register_script(
			'CMLW_HebCalenderJAVASCRIPT',
			plugins_url('assets/js/hebCalender.js', CMLW_AP_URL),
			'',
			'1.0',
			true
		);
		wp_enqueue_script('CMLW_HebCalenderJAVASCRIPT');
		
		
		
		
		/*
		 * Hebrew Calender Script
		 *
		 * wp_register_script(
			'CMLW_HEBCAL_GREG_TO_HEBREW',
			plugins_url('assets/lib/hebcal-js-master/client/hebcal.js', CMLW_AP_URL),
			'',
			'1.0',
			false
			);
		wp_enqueue_script('CMLW_HEBCAL_GREG_TO_HEBREW');*/
		
	}
	
	function CMLW_load_styles_enqueues(){
		wp_register_style(
			'CMLW_styleSheet',
			plugins_url('assets/css/app.css', CMLW_AP_URL)
		);
		wp_enqueue_style('CMLW_styleSheet');
	}