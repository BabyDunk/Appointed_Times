<?php
	/**
	 * Created by Chris Wilkinson.
	 * Title: appointed_times
	 * Date: 02/01/2019
	 * Time: 21:03
	 */
	
	
	function CMLW_makeShortCode(){
		?>
		
		<div id="CMLW-appointTimes">
		<h1><?php echo empty(get_option('CMLW_ap_title')) ? 'Yhwh Appointed Times' : esc_attr( get_option('CMLW_ap_title') ); ?> for <span id="CMLW-Title-Year">2018</span></h1>
		<p><?php echo empty(get_option('CMLW_ap_first_par')) ? 'A new day begins at sunset and not at midnight as we are used to with the gregorian calender' : esc_attr( get_option('CMLW_ap_first_par') ); ?></p>
		<p><?php echo empty(get_option('CMLW_ap_second_par')) ? 'So a biblical day stretches over 2 gregorian days. from sunset to sunset' : esc_attr( get_option('CMLW_ap_second_par') ); ?></p>
		<div id="CMLW-ap-layout">

        <div class="CMLW-ap-Title" data-ap-date="13 Adar" data-ap-day-count="1"><?php echo empty(get_option('CMLW_ap_purim')) ? 'Purim' : esc_attr( get_option('CMLW_ap_purim') ); ?>: </div><div class="CMLW-ap-Date">14 Adar</div>
        <div class="CMLW-ap-Title" data-ap-date="14 Nisan" data-ap-day-count="1"><?php echo empty(get_option('CMLW_ap_passover')) ? 'Passover' : esc_attr( get_option('CMLW_ap_passover') ); ?>: </div><div class="CMLW-ap-Date">14 Nisan</div>
		<div class="CMLW-ap-Title" data-ap-date="15 Nisan" data-ap-day-count="7"><?php echo empty(get_option('CMLW_ap_unleaven')) ? 'Feast of Unleavened Bread' : esc_attr( get_option('CMLW_ap_unleaven') ); ?>: </div><div class="CMLW-ap-Date">15-22 Nisan</div>
		<div class="CMLW-ap-Title" data-ap-date="16 Nisan" data-ap-day-count="1"><?php echo empty(get_option('CMLW_ap_firstfruits')) ? 'Feast of First Fruits' : esc_attr( get_option('CMLW_ap_firstfruits') ); ?>: </div><div class="CMLW-ap-Date">16 Nisan</div>
		<div class="CMLW-ap-Title" data-ap-date="16 Nisan" data-ap-day-count="50"><?php echo empty(get_option('CMLW_ap_omer')) ? 'Counting the Omer' : esc_attr( get_option('CMLW_ap_omer') ); ?>: </div><div class="CMLW-ap-Date">17 Nisan</div>
		<div class="CMLW-ap-Title" data-ap-date="5 Sivan" data-ap-day-count="1"><?php echo empty(get_option('CMLW_ap_shavuot')) ? 'Feast of Weeks (Shavuot)' : esc_attr( get_option('CMLW_ap_shavuot') ); ?>:</div><div class="CMLW-ap-Date">6 Sivan</div>
		<div class="CMLW-ap-Title" data-ap-date="29 Elul" data-ap-day-count="2"><?php echo empty(get_option('CMLW_ap_teruah')) ? 'Feast of Trumpets(Yom Teruah)' : esc_attr( get_option('CMLW_ap_teruah') ); ?>:</div><div class="CMLW-ap-Date">1 Tishrei</div>
		<div class="CMLW-ap-Title" data-ap-date="9 Tishrei" data-ap-day-count="1"><?php echo empty(get_option('CMLW_ap_kippur')) ? 'Day of Atonement(Yom Kippur)' : esc_attr( get_option('CMLW_ap_kippur') ); ?>: </div><div class="CMLW-ap-Date">10 Tishrei</div>
		<div class="CMLW-ap-Title" data-ap-date="14 Tishrei" data-ap-day-count="7"><?php echo empty(get_option('CMLW_ap_sukkot')) ? 'Feast of Tabernacles (Sukkot)' : esc_attr( get_option('CMLW_ap_sukkot') ); ?>:</div><div class="CMLW-ap-Date">15-22 Tishrei</div>
		<div class="CMLW-ap-Title" data-ap-date="24 Kislev" data-ap-day-count="1"><?php echo empty(get_option('CMLW_ap_chanukah')) ? 'Dedication (Chanukah)' : esc_attr( get_option('CMLW_ap_chanukah') ); ?>: </div><div class="CMLW-ap-Date">25 Kislev</div>
		
		</div><!-- CMLW-ap-layout End-->
		</div><!--CMLW-appointTimes End-->
		<input type="hidden" id="CMLW_ap_Nonce" value="<?php echo wp_create_nonce('CMLW_ap_Nonce') ?>">
		
		<?php }
		
	
	
	
	/**
	 *  Set appointed times json to db
	 */
	function CMLW_ajaxUploadedObj(){
		global $wpdb;
		
		$inputAPJson = $_POST['data'];
		
		if(!empty($inputAPJson)) {
			if(!wp_verify_nonce($_POST['_ajax_nonce'], 'CMLW_ap_Nonce')) {
				wp_die('Security Risk');
			}else{
				$setAPDateObj = $wpdb->update(
					$wpdb->prefix . 'cmlw_appointedtimes' ,
					[ 'ap_json' => $inputAPJson , 'updated' => date( 'Y-m-d H:i:s' ) ] ,
					[ 'id' => 1 ] ,
					[ '%s' ] ,
					[ '%d' ]
				);
			}
		
		}else{
			$setAPDateObj = 'You Submitted '. $inputAPJson;
		}
		
		echo $setAPDateObj;
	
		wp_die();
	}
	
	
	/**
	 *  Get appointed times json
	 */
	function CMLW_ajaxGetObj(){
		global $wpdb;
		
		$getAPDateObj = stripslashes($wpdb->get_row('SELECT `ap_json` FROM '.$wpdb->prefix.'cmlw_appointedtimes WHERE `id` = 1', object )->ap_json);
	
		if(empty($getAPDateObj)){
			$getAPDateObj = 'No Json Available';
		}
		echo $getAPDateObj;
		wp_die();
	}