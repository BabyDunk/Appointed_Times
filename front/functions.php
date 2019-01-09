<?php
	/**
	 * Created by Chris Wilkinson.
	 * Title: appointed_times
	 * Date: 02/01/2019
	 * Time: 21:03
	 */
	
	
	function CMLW_makeShortCode(){
		$html = '<div id="CMLW-appointTimes">';
		$html .= '</h1>Yhwh Appointed Times for <span id="CMLW-Title-Year">2018</span></h1>';
		$html .= '</p>A new day begins at sunset and not at midnight as we are used to with the gregorian calender</p>';
		$html .= '</p>So a biblical day stretches over 2 gregorian days. from sunset to sunset</p>';
		$html .= '<div id="CMLW-ap-layout">';
		
		$html .= '<div class="CMLW-ap-Title" data-ap-date="14 Nisan" data-ap-day-count="1">Passover: </div><div class="CMLW-ap-Date">14 Nisan</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="15 Nisan" data-ap-day-count="7">Feast of Unleavened Breads: </div><div class="CMLW-ap-Date">15-22 Nisan</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="16 Nisan" data-ap-day-count="1">Feast of First Fruits: </div><div class="CMLW-ap-Date">16 Nisan</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="16 Nisan" data-ap-day-count="50">Counting the Omer: </div><div class="CMLW-ap-Date">17 Nisan</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="6 Sivan" data-ap-day-count="1">Feast of Weeks (Pentecost):</div><div class="CMLW-ap-Date">6 Sivan</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="1 tishrei" data-ap-day-count="2">Feast of Trumpets(Yom Teruah):</div><div class="CMLW-ap-Date">1 Tishrei</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="10 tishrei" data-ap-day-count="1">Day of Atonement(Yom Kippur): </div><div class="CMLW-ap-Date">10 Tishrei</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="15 tishrei" data-ap-day-count="7">Feast of Tabernacles (Sukkot):</div><div class="CMLW-ap-Date">15-22 Tishrei</div>';
		$html .= '<div class="CMLW-ap-Title" data-ap-date="25 kislev" data-ap-day-count="1">Dedication (Chanukah): </div><div class="CMLW-ap-Date">25 Kislev</div>';

		$html .= '</div>';// CMLW-ap-layout End
		$html .= '</div>';// CMLW-appointTimes End
		$html .= '<input type="hidden" id="CMLW_ap_Nonce" value="'.wp_create_nonce('CMLW_ap_Nonce').'">';// The Nonce
		
		return $html;
	}
	
	
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