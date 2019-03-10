
class CMLW_Appointed_Time{
	
	//baseHeb = '5576-01-01';
	//baseGreg = '1971-09-20';
	
	constructor(year, month, day){
		this.year = year;
		this.month = month;
		this.day = day;
		this.calender = this.buildCal();
		this.gTime = new Date();
	}
	
	
	buildCal(){
		let timeObj = {
			year: this.year,
			months: []
		};
		
		this.yearlyCounter = 0;
		for (let x=1;x<(this.isLeapYear().mCount+1);x++){
			
			timeObj.months.push(this.makeMonth(x))
		}
		return timeObj;
	}
	
	isLeapYear() {
		let leapObj = {};
		if (this.year % 19 === 0) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		}else if (this.year % 19 === 3) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		}else if (this.year % 19 === 6) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		}else if (this.year % 19 === 8) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		}else if (this.year % 19 === 11) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		}else if (this.year % 19 === 14) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		}else if (this.year % 19 === 17) {
			leapObj.isLeap = true;
			leapObj.mCount =  13;
		} else {
			leapObj.isLeap = false;
			leapObj.mCount =  12;
		}
		
		return leapObj;
	}
	
	isGregLeapYear(gYear) {
		
		return (gYear%4 === 0);
	}
	
	makeDay(dayCount){
		let dayObj = [];
		let dayObjTemp = {dayNum: 0, shabbatDay: false, moed: ''};
		
		for(let x=1;x<(dayCount+1);x++){
			this.yearlyCounter++;
			dayObjTemp = {dayNum: 0, shabbatDay: false, moed: ''};
			dayObjTemp.dayNum = x;
			if(this.yearlyCounter % 7 === 0){
				dayObjTemp.shabbatDay = true;
			}
			dayObj.push(dayObjTemp);
		}
		
		return dayObj;
	}
	
	makeMonth(month){
		let monthObj = {name: '',monthNum: 0,dayCount: 0, dayObj: []};
		if(!isNaN(month)) {
			if (month === 1) {
				monthObj.monthNum = 1;
				monthObj.dayCount = 30;
				monthObj.dayObj = this.makeDay(30);
				monthObj.name = 'Tishrei';
			} else if (month === 2) {
				monthObj.monthNum = 2;
				monthObj.dayCount = (this.isLeapYear().isLeap) ? 30 : 29;
				monthObj.dayObj = this.makeDay((this.isLeapYear().isLeap) ? 30 : 29);
				monthObj.name = 'Cheshvan';
			} else if (month === 3) {
				monthObj.monthNum = 3;
				monthObj.dayCount = (this.isLeapYear().isLeap) ? 30 : 29;
				monthObj.dayObj = this.makeDay((this.isLeapYear().isLeap) ? 30 : 29);
				monthObj.name = 'Kislev';
			} else if (month === 4) {
				monthObj.monthNum = 4;
				monthObj.dayCount = 29;
				monthObj.dayObj = this.makeDay(29);
				monthObj.name = 'Tevet';
			} else if (month === 5) {
				monthObj.monthNum = 5;
				monthObj.dayCount = 30;
				monthObj.dayObj = this.makeDay(30);
				monthObj.name = 'Shevat';
			}
			
			if (this.isLeapYear().isLeap){
				
				if (month === 6) {
					monthObj.monthNum = 6;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Adar Alef';
				} else if (month === 7) {
					monthObj.monthNum = 7;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Adar Beit';
				}else if (month === 8) {
					monthObj.monthNum = 8;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Nissan';
				} else if (month === 9) {
					monthObj.monthNum = 9;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Iyar';
				} else if (month === 10) {
					monthObj.monthNum = 10;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Sivan';
				} else if (month === 11) {
					monthObj.monthNum = 11;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Tamuz';
				} else if (month === 12) {
					monthObj.monthNum = 12;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Av';
				} else if (month === 13) {
					monthObj.monthNum = 13;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Elul';
				}
				
			} else {
				
				if (month === 6) {
					monthObj.monthNum = 6;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Adar';
				} else if (month === 7) {
					monthObj.monthNum = 7;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Nissan';
				} else if (month === 8) {
					monthObj.monthNum = 8;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Iyar';
				} else if (month === 9) {
					monthObj.monthNum = 9;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Sivan';
				} else if (month === 10) {
					monthObj.monthNum = 10;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Tamuz';
				} else if (month === 11) {
					monthObj.monthNum = 11;
					monthObj.dayCount = 30;
					monthObj.dayObj = this.makeDay(30);
					monthObj.name = 'Av';
				} else if (month === 12) {
					monthObj.monthNum = 12;
					monthObj.dayCount = 29;
					monthObj.dayObj = this.makeDay(29);
					monthObj.name = 'Elul';
				}
			}
		}
		return monthObj;
	}
	
	moonPhase(){
		s
	}
	
	getMoonPhase(gregYear=this.gTime.getFullYear(), gregMonth=(this.gTime.getMonth()+1), gregDay=this.gTime.getDate(), gregHour=this.gTime.getHours(), gregMins=this.gTime.getMinutes(), gregSecs=this.gTime.getSeconds()){
		
		gregMonth -= 1;
		let monthVal = [31,28,31,30,31,30,31,31,30,31,30,31];
		let monthTVal = 0;
		let start1900 = 693975;
		
		
		if(gregMonth > 0) {
			for (let x = 0; x < gregMonth; x++) {
				if(x === 1 && this.isGregLeapYear(gregYear)){
					monthVal[x] = monthVal[x]+1;
				}
				monthTVal += monthVal[x];
			}
		}
		let tDay = (gregYear*365.25) + monthTVal + gregDay;
		let tTime = (Math.floor(tDay)*24*60*60) + (gregHour*60*60) + (gregHour*60) + gregSecs;
		//let tSeconds = tTime * (24*60*60);
		let moonSeconds = (29*24*60*60)+(((12*60)+44)*60)+2.806;
		
		let moonPhase = tTime%moonSeconds;
		
		console.log(tTime);
		console.log(Math.floor(tDay));
		
		console.log(monthTVal);
		console.log(gregDay);
		
		console.log(this.isGregLeapYear(gregYear));
		console.log(tTime);
		
		
		console.log(moonSeconds);
		console.log(moonPhase);
		console.log(moonPhase/60/60/24);
		
	}
	
}

let ap = new CMLW_Appointed_Time(5780,1,17);
let ap1 = new CMLW_Appointed_Time(5781,1,17);
let ap2 = new CMLW_Appointed_Time(5782,1,17);
let ap3 = new CMLW_Appointed_Time(5783,1,17);
let ap4 = new CMLW_Appointed_Time(5784,1,17);
let ap5 = new CMLW_Appointed_Time(5785,1,17);

/*console.log(ap);
console.log(ap1);
console.log(ap2);
console.log(ap3);
console.log(ap4);
console.log(ap5);*/
