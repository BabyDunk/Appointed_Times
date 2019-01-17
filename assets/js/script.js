'use strict';
var ajaxurl = window.location.origin+'/wp-admin/admin-ajax.php?';
const CMLW_Appointed_Times = {};
CMLW_Appointed_Times.getData = document.querySelectorAll('.CMLW-ap-Title');
CMLW_Appointed_Times.monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
CMLW_Appointed_Times.date = new Date();
CMLW_Appointed_Times.hebrewYear = 0;
CMLW_Appointed_Times.gatherDates = {
	"year_com": 2018,
	"yearly_dates": []
};


window.onload = function(){
	console.log('here')
	CMLW_ajaxConnectionData('action=CMLW_ajaxGetObj', 'get', '',  function (response) {
		CMLW_Appointed_Times.gatherDates.yearly_dates = [];
		CMLW_Appointed_Times.gatherDates = JSON.parse(response);
		
		if (CMLW_Appointed_Times.gatherDates.year_com === CMLW_Appointed_Times.date.getFullYear() && CMLW_Appointed_Times.gatherDates.yearly_dates.length > 0) {
			CMLW_buildDates(CMLW_Appointed_Times.gatherDates);
		}else{
			CMLW_buildDateFromHebcal()
		}
		
	});
};





function CMLW_buildDateFromHebcal() {
	let CMLW_loop;
	CMLW_Appointed_Times.gatherDates.yearly_dates = [];
	CMLW_Appointed_Times.gatherDates.year_com = CMLW_Appointed_Times.date.getFullYear();
	
	let x = 0;
	let loopHebDates = setTimeout(loopingHebDate, 1);
	
	function loopingHebDate() {
		CMLW_loop = CMLW_Appointed_Times.getData[x];
		let CMLW_dayCount = CMLW_loop.dataset.apDayCount;
		if (CMLW_loop.dataset.apDate) {
			CMLW_loop = CMLW_loop.dataset.apDate.split(' ');
			CMLW_getGregToHebDates(
				CMLW_Appointed_Times.date.getFullYear(),
				(CMLW_Appointed_Times.date.getMonth() + 1),
				CMLW_Appointed_Times.date.getDate(),
				'greg'
			).then(
				function (resolve) {
					return CMLW_getGregToHebDates(resolve.hy, CMLW_loop[1], CMLW_loop[0], 'heb')
				}, CMLW_handleError).then(function (resolved) {
				
				if (resolved.gy !== CMLW_Appointed_Times.date.getFullYear()) {
					
					return CMLW_getGregToHebDates((resolved.hy + 1), CMLW_loop[1], CMLW_loop[0], 'heb');
					
				} else {
					CMLW_Appointed_Times.gatherDates.yearly_dates.push({
						"hebDate": CMLW_loop[0] + ' ' + CMLW_loop[1],
						"hebDayCount": CMLW_dayCount,
						"hebObj": resolved
					});
				}
				
			}, CMLW_handleError).then(function (resolved3) {
				if (resolved3) {
					CMLW_Appointed_Times.gatherDates.yearly_dates.push({
						"hebDate": CMLW_loop[0] + ' ' + CMLW_loop[1],
						"hebDayCount": CMLW_dayCount,
						"hebObj": resolved3
					});
					
				}
				
				loopHebDates = setTimeout(loopingHebDate, 400);
				if ((x + 1) >= CMLW_Appointed_Times.getData.length) {
					clearTimeout(loopHebDates);
					x = 0;
					CMLW_ajaxConnectionData(
						'action=CMLW_ajaxUploadedObj',
						'post',
						'data=' + JSON.stringify(CMLW_Appointed_Times.gatherDates) + '&_ajax_nonce=' + document.getElementById('CMLW_ap_Nonce').value);
					CMLW_buildDates(CMLW_Appointed_Times.gatherDates)
				}
				x++;
				
			}, CMLW_handleError);
		}
		
	}
}
function CMLW_buildDates(obj){
	if(obj.yearly_dates.length > 0) {
		for (let x = 0; x < obj.yearly_dates.length; x++) {
			let objHebYear = obj.yearly_dates[x];
			
			let collectDate = objHebYear.hebObj.gy + ' ' + (objHebYear.hebObj.gm) + ' ' + objHebYear.hebObj.gd;
			let buildDate = '';
			
			let newDate = new Date(collectDate);
			let holderDate = new Date(newDate);
			buildDate += newDate.getDate();
			
			newDate.setDate(newDate.getDate() + Number(objHebYear.hebDayCount));
			
			if (holderDate.getMonth() !== newDate.getMonth()) {
				buildDate += ' ' + CMLW_Appointed_Times.monthNames[holderDate.getMonth()] + ' - ' + newDate.getDate() + ' ' + CMLW_Appointed_Times.monthNames[newDate.getMonth()];
			} else {
				buildDate += ' - ' + newDate.getDate() + ' ' + CMLW_Appointed_Times.monthNames[newDate.getMonth()];
			}
			
			document.getElementById('CMLW-Title-Year').innerHTML = CMLW_Appointed_Times.date.getFullYear();
			
			for (let x = 0; x < CMLW_Appointed_Times.getData.length; x++) {
				
				if (CMLW_Appointed_Times.getData[x].dataset.apDayCount === objHebYear.hebDayCount && CMLW_Appointed_Times.getData[x].dataset.apDate === objHebYear.hebDate) {
					CMLW_Appointed_Times.getData[x].nextSibling.innerHTML = buildDate;
				}
			}
		}
	}
}
function CMLW_getGregToHebDates(year,month,day, dType){
	return new Promise(function (resolve, reject) {
		let buildUrl;
		if(dType === 'heb'){
			month = month[0].toUpperCase()+month.slice(1);
			buildUrl = 'https://www.hebcal.com/converter/?cfg=json'+
			           '&hy='+year+
			           '&hm='+month+
			           '&hd='+day+
			           '&h2g=1';
		}else if (dType === 'greg'){
			buildUrl = 'https://www.hebcal.com/converter/?cfg=json&'+
			           'gy='+year+
			           '&gm='+month+
			           '&gd='+day+
			           '&g2h=1&gs=on';
		}
		
		let aJax = new XMLHttpRequest();
		aJax.open('GET', buildUrl, true);
		aJax.onreadystatechange = function () {
			if(aJax.readyState === 4){
				if(aJax.status === 200){
					resolve(JSON.parse(aJax.responseText));
				}else{
					reject(aJax);
				}
			}
		};
		aJax.send();
	});
}
function CMLW_handleError(failure){
	console.log('Bad News - Error Response: '+failure.status)
}
function CMLW_ajaxConnectionData(url, method, data='', callback=null){
	url = ajaxurl+url;
	let ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
		console.log(ajax)
		if(callback !== null) {
			if (ajax.readyState === 4 && ajax.status === 200) callback(ajax.responseText);
		}
	};
	ajax.open(method, url, true);
	if(data !== ''){
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	}
	ajax.send(data);
	
}