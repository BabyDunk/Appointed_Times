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





ajaxConnectionData('action=CMLW_ajaxGetObj', 'get', '',  function (response) {
	CMLW_Appointed_Times.gatherDates.yearly_dates = [];
	CMLW_Appointed_Times.gatherDates = JSON.parse(response);
	
	if (CMLW_Appointed_Times.gatherDates.year_com === CMLW_Appointed_Times.date.getFullYear() && CMLW_Appointed_Times.gatherDates.yearly_dates.length > 0) {
		CMLW_buildDates(CMLW_Appointed_Times.gatherDates);
	}else{
		CMLW_getYearlyDates();
		ajaxConnectionData('action=CMLW_ajaxGetObj', 'get', '', function (response) {
			CMLW_Appointed_Times.gatherDates.yearly_dates = [];
			CMLW_Appointed_Times.gatherDates = JSON.parse(response);
			CMLW_buildDates(CMLW_Appointed_Times.gatherDates);
		});
	}
	
});






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
function CMLW_getYearlyDates() {
	gregToHebrewYear(CMLW_Appointed_Times.date.getFullYear(), (CMLW_Appointed_Times.date.getMonth() + 1), CMLW_Appointed_Times.date.getDate(), function (response) {
		if (response) {
			CMLW_Appointed_Times.hebrewYear = response.hy;
			let CMLW_loop;
			CMLW_Appointed_Times.gatherDates.yearly_dates = [];
			CMLW_Appointed_Times.gatherDates.year_com = CMLW_Appointed_Times.date.getFullYear();
			
			for (let x = 0; x < CMLW_Appointed_Times.getData.length; x++) {
				CMLW_loop = CMLW_Appointed_Times.getData[x];
				let CMLW_dayCount = CMLW_loop.dataset.apDayCount;
				if (CMLW_loop.dataset.apDate) {
					CMLW_loop = CMLW_loop.dataset.apDate.split(' ');
					hebrewToGreg(response.hy, CMLW_loop[1], CMLW_loop[0], function (response) {
						let hebToGreg = response;
						if (hebToGreg.gy !== CMLW_Appointed_Times.date.getFullYear()) {
							hebToGreg = {};
							hebrewToGreg((CMLW_Appointed_Times.hebrewYear + 1), CMLW_loop[1], CMLW_loop[0], function (response) {
								hebToGreg = response;
								
							});
						}
						
						// Collect dates
						CMLW_Appointed_Times.gatherDates.yearly_dates.push({
							"hebDate": CMLW_loop[0] + ' ' + CMLW_loop[1],
							"hebDayCount": CMLW_dayCount,
							"hebObj": hebToGreg
						});
						
					});
				}
			}
			
			ajaxConnectionData(
				'action=CMLW_ajaxUploadedObj',
				'post',
				'data='+JSON.stringify(CMLW_Appointed_Times.gatherDates)+'&_ajax_nonce='+document.getElementById('CMLW_ap_Nonce').value);
		}
	});
}
function ajaxConnectionData(url, method, data='', callback=null){
	url = ajaxurl+url;
	let ajax = new XMLHttpRequest();
	
	ajax.onreadystatechange = function(){
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
function gregToHebrewYear(year,month,day,callback) {
	let ajax = new XMLHttpRequest();
	let Url = 'https://www.hebcal.com/converter/?cfg=json&gy='+year+'&gm='+month+'&gd='+day+'&g2h=1&gs=on';
	ajax.onreadystatechange = function(){
		if(ajax.readyState === 4 && ajax.status === 200){
			callback(JSON.parse(ajax.responseText));
		}
	};
	ajax.open('GET', Url, false);
	ajax.send();
}
function hebrewToGreg(year,month,day,callback) {
	month = month[0].toUpperCase()+month.slice(1);
	let ajax = new XMLHttpRequest();
	let Url = 'https://www.hebcal.com/converter/?cfg=json&hy='+year+'&hm='+month+'&hd='+day+'&h2g=1';
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState === 4 && ajax.status === 200){
			callback(JSON.parse(ajax.responseText));
		}
	};
	ajax.open('GET', Url, false);
	ajax.send();
}