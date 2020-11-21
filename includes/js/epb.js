

function checkIntNumber(obj,mid, form,index )
{
	var i=0,j=0;var x=0; var flag=0;var ok=0;

	var str="";
	var c=0;
	if((index != -1) && (index != null))
	{
		obj = form.elements[obj.name][index];
	}
	else
	{
		obj = obj;
	}
	str = obj.value;
	if(str.charAt(0)==0){
		obj.value=str.slice(1,str.length);
		return;
	}
	for(i = 0 ; i < str.length; i++){
		x=str.charCodeAt(i);
		if((x >= 48) && (x <= 57)){
			ok = 1;
		}else if(x==46){
			alert("You can not enter float point.");
			obj.value=str.slice(0,str.length-1);
			return;
		}else{  ok=0;
		break;
		}
	}

	if(ok==0){
		var temp = parseInt(obj.value);
		if(isNaN(temp))
		obj.value='';
		else{
			obj.value= temp;
			alert(mid);
		}
		obj.focus();
		obj.select();
	}

}

function checkDoubleNumber(Obj,msg){

	var i=0; var x=0; var flag=0;var ok=0;
	var str="";
	str=trim(Obj.value);
	if(str.charAt(0)==0){
		Obj.value=str.slice(1,str.length);
		return;
	}
	var afterPointStr="";
	for(i = 0 ; i < str.length; i++){
		x=str.charCodeAt(i);

		if((x >= 48) && (x <= 57)){
			ok = 1;
		}else if(x==46 && flag == 0){
			flag=1;
			ok=1;
		}else if(x==46 && flag == 1){
			alert("You can not enter more than one float point.");
			Obj.value=str.slice(0,str.length-1);
			return;
		}else{  ok=0;
		break;
		}
	}
	if(str.indexOf('.')!=-1 && flag == 1){
		afterPointStr = str.slice(str.indexOf('.')+1,str.length);
		if(afterPointStr.length > 2){
			ok = 0;
			msg="You can not enter two digit after float point."
			Obj.value=str.slice(0,str.length-1);
		}
	}
	if(str.indexOf('.')==-1 && str.length >= Obj.maxLength-2){
		ok = 0;
		msg="You can not enter more than " + (Obj.maxLength-3)+ " digits without float point";
		Obj.value=str.slice(0,str.length-1);
	}

	if(ok==0){
		var temp = parseFloat(Obj.value);
		if(isNaN(temp))
		Obj.value='';
		else{
			Obj.value= temp;
			alert(msg);
		}
		Obj.focus();
		Obj.select();
	}
}



function emailCheck(str) {

	var at="@";
	var dot=".";
	var lat=str.indexOf(at);
	var lstr=str.length;
	var ldot=str.indexOf(dot);

	if (str.indexOf(at)==-1){

		return false;
	}

	else if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){

		return false;
	}

	else if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){

		return false;
	}

	else if (str.indexOf(at,(lat+1))!=-1){

		return false;
	}

	else if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){

		return false;
	}

	else if (str.indexOf(dot,(lat+2))==-1){

		return false;
	}

	else if (str.indexOf(" ")!=-1){

		return false;
	}
	else {
		return true;
	}

}

/*
* Author: Morshed
* file extension check by morshed
* var form object
* var ext -> ",.jpg,.doc,";
* var img -> filName
*/
function validate_file_extension(form,ext,img){
	var validfiles=ext;
	var fileext= ","+img.substr(img.lastIndexOf(".")+1)+",";
	fileext=fileext.toLowerCase();
	var available=validfiles.indexOf(fileext);
	if (available==-1)
	{
		return false;
	}
	return true;
}

function checkdate(objName) {
	var datefield = objName;
	if (chkdate(objName) == false) {
		datefield.select();
		alert("That date is invalid.  Please try again.");
		datefield.focus();
		return false;
	}
	else {
		return true;
	}
}

function chkdate(objName) {
	//var strDatestyle = "US"; //United States date style
	var strDatestyle = "EU";  //European date style
	var strDate;
	var strDateArray;
	var strDay;
	var strMonth;
	var strYear;
	var intday;
	var intMonth;
	var intYear;
	var booFound = false;
	var datefield = objName;
	//var strSeparatorArray = new Array("-"," ","/",".");
	var strSeparatorArray = new Array("-");
	var intElementNr;
	var err = 0;
	var strMonthArray = new Array(12);
	strMonthArray[0] = "Jan";
	strMonthArray[1] = "Feb";
	strMonthArray[2] = "Mar";
	strMonthArray[3] = "Apr";
	strMonthArray[4] = "May";
	strMonthArray[5] = "Jun";
	strMonthArray[6] = "Jul";
	strMonthArray[7] = "Aug";
	strMonthArray[8] = "Sep";
	strMonthArray[9] = "Oct";
	strMonthArray[10] = "Nov";
	strMonthArray[11] = "Dec";
	strDate = datefield.value;
	if (strDate.length < 1) {
		return true;
	}
	//for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
	//alert(strDate.indexOf(strSeparatorArray[intElementNr]));
	if (strDate.indexOf(strSeparatorArray) != -1) {
		strDateArray = strDate.split(strSeparatorArray);

		if (strDateArray.length !=3) {
			err = 1;
			return false;
		}
		else {
			strDay = strDateArray[0];
			strMonth = strDateArray[1];
			strYear = strDateArray[2];
		}
		booFound = true;
	}
	else{
		return false;
	}
	// }
	if (booFound == false) {
		if (strDate.length>5) {
			strDay = strDate.substr(0, 2);
			strMonth = strDate.substr(2, 2);
			strYear = strDate.substr(4);
		}
	}
	if(strYear.length != 4 )
	return false;
	// if (strYear.length == 2 ) {
	//strYear = '20' + strYear;
	// }
	// US style
	if (strDatestyle == "US") {
		strTemp = strDay;
		strDay = strMonth;
		strMonth = strTemp;
	}
	intday = parseInt(strDay, 10);
	if (isNaN(intday)) {
		err = 2;
		return false;
	}
	intMonth = parseInt(strMonth, 10);
	if (isNaN(intMonth)) {
		for (i = 0;i<12;i++) {
			if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
				intMonth = i+1;
				strMonth = strMonthArray[i];
				i = 12;
			}
		}
		if (isNaN(intMonth)) {
			err = 3;
			return false;
		}
	}
	intYear = parseInt(strYear, 10);
	if (isNaN(intYear)) {
		err = 4;
		return false;
	}
	if (intMonth>12 || intMonth<1) {
		err = 5;
		return false;
	}
	if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
		err = 6;
		return false;
	}
	if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
		err = 7;
		return false;
	}
	if (intMonth == 2) {
		if (intday < 1) {
			err = 8;
			return false;
		}
		if (LeapYear(intYear) == true) {
			if (intday > 29) {
				err = 9;
				return false;
			}
		}
		else {
			if (intday > 28) {
				err = 10;
				return false;
			}
		}
	}
	/*
	if (strDatestyle == "US") {
	datefield.value = strMonthArray[intMonth-1] + " " + intday+" " + strYear;
	}
	else {
	datefield.value = intday + " " + strMonthArray[intMonth-1] + " " + strYear;
	}
	*/
	return true;
}

function LeapYear(intYear) 
{
         if (intYear % 100 == 0)
         {
                 if (intYear % 400 == 0) { return true; }
         }
         else
         {
                 if ((intYear % 4) == 0) { return true; }
         }
         return false;
 }

