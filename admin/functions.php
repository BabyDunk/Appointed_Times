<?php
	/**
	 * Created by Chris Wilkinson.
	 * Title: appointed_times
	 * Date: 06/01/2019
	 * Time: 05:49
	 */
	


	
	/**
	 * Create table and insert data for plugin
	 */
	function CMLW_onActivationPlugin(){
		global $wpdb;
		
		$defaultJson = '{"year_com":2018,"yearly_dates":[]}';


		$create_sql = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'cmlw_appointedtimes` (
					  `id` int DEFAULT 1,
					  `ap_json` text DEFAULT NULL,
					  `updated` varchar(50) default NULL,
					  primary key (`id`)
					) engine=InnoDB '.$wpdb->get_charset_collate();
					
		
		require( ABSPATH."/wp-admin/includes/upgrade.php" );
		
		dbDelta($create_sql);
		
		$wpdb->insert(
			$wpdb->prefix.'cmlw_appointedtimes',
			['ap_json'=>$defaultJson, 'updated'=> date('Y-m-d H:i:s')],
			['%s','%s']
		);
	}
	
	/**
	 * Drop table when uninstalling plugin
	 */
	function CMLW_onUninstallPlugin(){
		global $wpdb;
		$wpdb->query('DROP TABLE IF EXISTS `'.$wpdb->prefix.'cmlw_appointedtimes`');
	}