function popWin(url,windowName) {
	if(!url) url="please_wait.html";
	if(!windowName) windowName="popup";
	window.open(url,windowName,'toolbar=no,status=no,resizable=yes,scrollbars=yes,location=no,menubar=no,directories=no,copyhistory=no,width=640,height=480');
}

function popWinSmall(url,windowName) {
	if(!url) url="please_wait.html";
	if(!windowName) windowName="popup";
	window.open(url,windowName,'toolbar=no,status=no,resizable=no,scrollbars=yes,location=no,menubar=no,directories=no,copyhistory=no,width=320,height=240');
}

function deleteCheck(table,id) {
	 if (confirm('Are You Sure You Want to Permanently Delete This Record?')) {
	 	MM_goToURL('parent','form.php?table=' + table + '&action=delete&id=' + id);
	 } else {
		document.MM_returnValue = false;
	 }
}

function setOrderBy(inOrderBy) {
	if (inOrderBy) {
		for (i=0;i<document.search_form.orderBy.options.length;i++) {
			if (document.search_form.orderBy.options[i].value == inOrderBy) {
				document.search_form.orderBy.options[i].selected=true;
			}
		}
	}
}

function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}

function MM_popupMsg(msg) { //v1.0
  alert(msg);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') {
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (val<min || max<val) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_setTextOfTextfield(objName,x,newText) { //v3.0
  var obj = MM_findObj(objName); if (obj) obj.value = newText;
}

function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}

var hexVals = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
var unsafeString = "\"<>%\\^[]`";

function highlight(element1){element1.focus();element1.select();}

function URLDecode()
{
	var returnstr=unescape(form1.string1.value);
	document.all.div1.innerHTML='RESULT:<br><textarea name="textarea2">'+returnstr+'</textarea>';
	highlight(form3.textarea2);
        // while coding i found that IE had problem writing '<form>' to innerhtml. </form> was ok. 'unknown runtime error' IE5.5.
}

function URLEncode(val)
{
        var state   = 'urlenc';
        var len     = val.length;
        var backlen = len;
        var i       = 0;

        var newStr  = "";
        var frag    = "";
        var encval  = "";

        for (i=0;i<len;i++) 
        {
// uncomment the next 7 commented lines to encode only the usual URL unsafe characters
//                if (isURLok(val.substring(i,i+1)))
//                {
//                        newStr = newStr + val.substring(i,i+1);
//                }
//                else
//                {
                        tval1=val.substring(i,i+1);
                        newStr = newStr + "%" + decToHex(tval1.charCodeAt(0),16);
//                }
        }
	document.all.div1.innerHTML='RESULT:<br><textarea name="textarea2">'+newStr+'</textarea>';
	highlight(form3.textarea2);
}

function decToHex(num, radix) // part of URL Encode
{
        var hexString = "";
        while (num >= radix)
        {
               temp = num % radix;
               num = Math.floor(num / radix);
               hexString += hexVals[temp];
        }
        hexString += hexVals[num];
        return reversal(hexString);
}

function reversal(s) // part of URL Encode
{
        var len = s.length;
        var trans = "";
        for (i=0; i<len; i++)
        {
                trans = trans + s.substring(len-i-1, len-i);
        }
        s = trans;
        return s;
}

function isURLok(compareChar) // part of URL Encode
{
        if (unsafeString.indexOf(compareChar) == -1 && compareChar.charCodeAt(0) > 32 && compareChar.charCodeAt(0) < 123) 
        {
                return true;
        }
        else
        {
                return false;
        }
}
//WDF 2/26/03 Add getDayofWeek and getUserTime functions

// getDayofWeek - a numeric date into a day of the week
//	input - date_str - a date string in the format yyyy-mm-dd 
//	returns - a String that is the day of the week, e.g. 'Friday' 
//  Notes - This function is NOT internationalized and only returns the english day of the week
function getDayofWeek(date_str) {
	var dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	var date_fields = date_str.split('-');
	//Note Date uses 0-11 for months, not 1-12, so
	date_fields[1]--;
	var d = new Date(date_fields[0], date_fields[1], date_fields[2]);
	return dayOfWeek[d.getDay()];
}		 
// getUserTime - translate 24 hour clock time to AM/PM
//	input - time_str - a time string in the format hh:mm:ss (the :ss are optional)
//	returns - a String in the format hh:mm AM|PM. 
//		Note, the preceding 0 on the time is dropped, so 03:00:00, is returned as
//		3:00 AM
function getUserTime(time_str) {
	var time_fields = time_str.split(':')
	var am_pm = 'AM';
	time_fields[0] -= 0;  //Convert hours to numbers
	
	//Check for the PM case.
	if (time_fields[0] > 11) {
		am_pm = 'PM';
		if (time_fields[0] > 12) {
			time_fields[0] -= 12;
			//Special case to handle 24:00:00
			if (time_fields[0] == 12) {
				am_pm = 'AM';
			}
		}
	}
	//Remember the special case for 00:mm:ss, its 12:mm AM
	if (time_fields[0] == 0) {
			time_fields[0] = 12;
	}
	return time_fields[0] + ':' + time_fields[1] + ' ' + am_pm;
}
//WDF 2/26/03 Add createTicket and createBadge functions

// createTicket - This function generates the HTML code needed to print an event ticket.
//	input - logoFile - The name of the con logo file
//			eventNumber - the complete event number (e.g. 10.2)
//			price - The cost of the event, in dollars
//			conName - The name of the con
//			eventName - The complete name of the event
//			eventDate - the date of the event, in yyyy-mm-dd format
//			eventStart - the start time of the event, in hh:mm:ss format
//			eventEnd - the end time of the event, in hh:mm:ss format 
//	returns - Nothing 
//  Notes - The HTML presented here is tuned for Internet Explorer 5.x for Macintosh (only tested under OS X)
//			and for Internet Explorer 6.0 for Windows. It assumes that we are printing to a Dymo label printer
//			formatted for label badge stock (30365, 2.43" x 3.5" in landscape mode. All other uses are
//			at the risk of the user.
function createTicket(logoFile, eventNumber, price, conName, eventName, eventDate, eventStart, eventEnd) {

//	Define properties for PC printing
	var tWidth = "280";
	var tHeight = "183";
	var logoWidth = "80";
	var logoHeight = "80";
	var evNumHeight = "53";
	var evNumSize = "7";
	var priceHeight = "27";
	var priceSize = "4";
	var evNumWidth = "200";
	var conNameHeight = "26";
	var conNameSize = "4";
	var evNameHeight = "40";
	var evNameSize = "3";
	var timeHeight = "27";
	var timeSize = "3";
	var isMac = navigator.platform.indexOf("Mac") != -1;
//	redefine properties for Mac printing
	if (isMac) {
		tWidth = "210";
		tHeight = "140";
		logoWidth = "60";
		logoHeight = "60";
		evNumHeight = "40";
		evNumSize = "6";
		priceHeight = "20";
		priceSize = "3";
		evNumWidth = "150";
		conNameHeight = "20";
		conNameSize = "3";
		evNameHeight = "30";
		evNameSize = "2";
		timeHeight = "30";
		timeSize = "2";
		}

	document.write('<table width=',tWidth,' border="0" height=',tHeight,' cellpadding="0" cellspacing="0" name="badge">');
	document.write('<tr>'); 
	document.write('<td rowspan="2" width=',logoWidth,' align="center" valign="center">'); 
	document.write('<img src="images/logos/',logoFile,'" width=',logoWidth,' height=',logoHeight,'>');
	document.write('</td>');
	document.write('<td height = ',evNumHeight,' width=',evNumWidth,' align = "right">'); 
	document.write('<b><font size=',evNumSize,' face="Arial, Helvetica, sans-serif">',eventNumber, '</font></b>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr>'); 
	document.write('<td height = '+priceHeight+' width='+evNumWidth+' align = "right">');
	document.write('<font size='+priceSize+' face="Arial, Helvetica, sans-serif">$',price,'</font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr>');
	document.write('<td colspan="2" height='+conNameHeight+' align="center" valign="center" bgcolor="black"> ');
	document.write('<font color="white" size='+conNameSize+' face="Arial, Helvetica, sans-serif"><b>',conName,'</b></font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr> ');
	document.write('<td colspan="2" height='+evNameHeight+' align="center" > ');
	document.write('<font size='+evNameSize+'>',eventName,'</font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr> ');
	document.write('<td colspan="2" height='+timeHeight+' align="center" valign="center" > ');
	document.write('<font size='+timeSize+' face="Arial, Helvetica, sans-serif">');
	document.write(getDayofWeek(eventDate), '  ');
	document.write(getUserTime(eventStart), '-');
	document.write(getUserTime(eventEnd));
	document.write('</font></td></tr></table>');
	}

// createBadge - This function generates the HTML code needed to print person's badge.
//	input - logoFile - The name of the con logo file
//			badgeNum - the number of the badge
//			regType - The registration type
//			rpgaNum - The person's RPGA number
//			conName - The name of the con
//			firstName - The person's first name
//			laststName - The person's last name
//	returns - Nothing 
//  Notes - The HTML presented here is tuned for Internet Explorer 5.x for Macintosh (only tested under OS X)
//			and for Internet Explorer 6.0 for Windows. It assumes that we are printing to a Dymo label printer
//			formatted for label badge stock (30365, 2.43" x 3.5" in landscape mode. All other uses are
//			at the risk of the user.
function createBadge(logoFile, badgeNum, regType, rpgaNum, conName, firstName, lastName) {

//	Define properties for PC printing
	var tWidth = "280";
	var tHeight = "183";
	var logoWidth = "80";
	var logoHeight = "80";
	var badgeNumHeight = "40";
	var badgeNumSize = "7";
	var regHeight = "26";
	var regSize = "4";
	var rpgaHeight = "14";
	var rpgaSize = "2";
	var evNumWidth = "200";
	var conNameHeight = "25";
	var conNameSize = "4";
	var firstNameHeight = "40";
	var firstNameSize = "6";
	var lastNameHeight = "33";
	var lastNameSize = "5";
	var isMac = navigator.platform.indexOf("Mac") != -1;
//	redefine properties for Mac printing
	if (isMac) {
		tWidth = "210";
		tHeight = "140";
		logoWidth = "60";
		logoHeight = "60";
		badgeNumHeight = "30";
		badgeNumSize = "6";
		regHeight = "20";
		regSize = "3";
		rpgaHeight = "10";
		rpgaSize = "1";
		evNumWidth = "150";
		conNameHeight = "20";
		conNameSize = "3";
		firstNameHeight = "35";
		firstNameSize = "5";
		lastNameHeight = "25";
		lastNameSize = "4";
		}

	document.write('<table width=',tWidth,' border="0" height=',tHeight,' cellpadding="0" cellspacing="0" name="badge">');
	document.write('<tr>'); 
	document.write('<td rowspan="3" width=',logoWidth,' align="center" valign="center">'); 
	document.write('<img src="images/logos/',logoFile,'" width=',logoWidth,' height=',logoHeight,'>');
	document.write('</td>');
	document.write('<td height = ',badgeNumHeight,' width=',evNumWidth,' align = "right">'); 
	document.write('<b><font size=',badgeNumSize,' face="Arial, Helvetica, sans-serif">',badgeNum, '</font></b>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr>'); 
	document.write('<td height = ',regHeight,' width=',evNumWidth,' align = "right">');
	document.write('<font size=',regSize,' face="Arial, Helvetica, sans-serif">',regType,'</font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr>'); 
	document.write('<td height = ',rpgaHeight,' width=',evNumWidth,' align = "right">');
	document.write('<font size=',rpgaSize,' face="Arial, Helvetica, sans-serif">');
	if (rpgaNum != 0) {
		document.write('RPGA: ',rpgaNum);
	}
	else {
		document.write(' ');
	}
	document.write('</font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr>');
	document.write('<td colspan="2" height=',conNameHeight,' align="center" valign="center" bgcolor="black"> ');
	document.write('<font color="white" size=',conNameSize,' face="Arial, Helvetica, sans-serif"><b>',conName,'</b></font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr> ');
	document.write('<td colspan="2" height=',firstNameHeight,' align="center" > ');
	document.write('<font size=',firstNameSize,'>',firstName,'</font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('<tr> ');
	document.write('<td colspan="2" height=',lastNameHeight,' align="center" > ');
	document.write('<font size=',lastNameSize,'>',lastName,'</font>');
	document.write('</td>');
	document.write('</tr>');
	document.write('</table>');
	}

