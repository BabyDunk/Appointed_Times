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
	
	function CMLW_loadAdministratorPage(){
		add_options_page(
			'Appointed Times Settings',
			'Appointed Times Settings',
			'manage_options',
			'CMLW_apointedTimesMenu',
			'CMLW_makeAdministratorPage'
			);
	}
	
	function CMLW_makeAdministratorPage(){
	?>

		<div class="wrap">
		<h1>Appointed Times Settings</h1>
		
		<form method="post" action="options.php">
		<?php settings_fields( 'CMLW_apointedTimesOptions' ); ?>
		<?php do_settings_sections( 'CMLW_apointedTimesOptions' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Title</th>
					<td><input type="text" name="CMLW_ap_title" value="<?php echo esc_attr( get_option('CMLW_ap_title') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">First Paragraph</th>
					<td><textarea name="CMLW_ap_first_par" ><?php echo esc_attr( get_option('CMLW_ap_first_par') ); ?></textarea></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Second Paragraph</th>
					<td><textarea name="CMLW_ap_second_par" ><?php echo esc_attr( get_option('CMLW_ap_second_par') ); ?></textarea></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<h4>Change Feast Name:</h4>
					</th>
				</tr>
				
				<tr valign="top">
					<th scope="row">Passover</th>
					<td><input type="text" name="CMLW_ap_passover" value="<?php echo esc_attr( get_option('CMLW_ap_passover') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Feast of Unleaven Bread</th>
					<td><input type="text" name="CMLW_ap_unleaven" value="<?php echo esc_attr( get_option('CMLW_ap_unleaven') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Feast of First Fruits</th>
					<td><input type="text" name="CMLW_ap_firstfruits" value="<?php echo esc_attr( get_option('CMLW_ap_firstfruits') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Counting the Omer</th>
					<td><input type="text" name="CMLW_ap_omer" value="<?php echo esc_attr( get_option('CMLW_ap_omer') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Feast of Weeks</th>
					<td><input type="text" name="CMLW_ap_shavuot" value="<?php echo esc_attr( get_option('CMLW_ap_shavuot') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Feast of Trumpets</th>
					<td><input type="text" name="CMLW_ap_teruah" value="<?php echo esc_attr( get_option('CMLW_ap_teruah') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Feast of Repentance</th>
					<td><input type="text" name="CMLW_ap_kippur" value="<?php echo esc_attr( get_option('CMLW_ap_kippur') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Feast of Tabernacles</th>
					<td><input type="text" name="CMLW_ap_sukkot" value="<?php echo esc_attr( get_option('CMLW_ap_sukkot') ); ?>" /></td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Hanukkah</th>
					<td><input type="text" name="CMLW_ap_chanukah" value="<?php echo esc_attr( get_option('CMLW_ap_chanukah') ); ?>" /></td>
				</tr>
			</table>
		
		<?php submit_button();; ?>
		</form>
		
		
		</div>
		
	<?php }
	
	
	function CMLW_registerOptions(){
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_title', ['string','substring of title','','','Yhwh Appointed Times']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_first_par', ['string','First paragraph','','','A new day begins at sunset and not at midnight as we are used to with the gregorian calender']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_second_par', ['string','Second Paragraph','','','So a biblical day stretches over 2 gregorian days. from sunset to sunset']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_passover', ['string','Change name of this feast','','','Passover']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_unleaven', ['string','Change name of this feast','','','Unleaven Bread']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_firstfruits', ['string','Change name of this feast','','','First Fruits']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_omer', ['string','Change name of this feast','','','Counting the Omer']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_shavuot', ['string','Change name of this feast','','','Feast of Weeks']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_teruah', ['string','Change name of this feast','','','Feast of Trumpets']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_kippur', ['string','Change name of this feast','','','Feast of Repentance']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_sukkot', ['string','Change name of this feast','','','Feast of Tabernacles']);
		register_setting('CMLW_apointedTimesOptions', 'CMLW_ap_chanukah', ['string','Change name of this feast','','','Hanukkah']);
	}