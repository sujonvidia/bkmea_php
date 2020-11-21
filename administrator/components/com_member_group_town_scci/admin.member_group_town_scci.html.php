<?php
/**
* @version $Id: admin.member_group_town_scci.html.php,v 1.21 2006/06/18 09:33:48 morshed Exp $
* @package Mambo
* @subpackage Categories
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Categories
*/
class HTML_MemberGroup_Town {

        /**
        * Writes a list of the categories for a section
        * @param array An array of category objects
        * @param string The name of the category section
        */
        function show( &$rows, &$pageNav, &$lists) {
                global $my, $mosConfig_live_site;
                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm" id="adminForm">
                <table class="adminheading">
                <tr>
                <tr>
                        <th>
                        Group/ Town Association
                        </th>
                        <td>
                        Filter :
                        </td>
                        <td>
                        <input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
                        </td>
                        <td width="right">
                        <?php echo $lists['search_type_id']; ?>
                        </td>
                </tr>
                </tr>
                </table>

                <table class="adminlist">
                <tr>
                        <th width="10" align="left">
                        #
                        </th>
                        <th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th>
                        <th class="title" align="left" width=20%>
                        Membership Code
                        </th>
                        <th class="title" width=35%>
                        Name
                        </th>
                        <th class="title" width=30% align=left>
                        Representative Name
                        </th>

                        <th class="title" width=15% align=center>
                        Member Type
                        </th>

                </tr>
                <?php
                $k = 0;

                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_member_group_town_scci&task=editA&hidemainmenu=1&id='. $row->id;
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php echo $pageNav->rowNumber( $i );  ?>
                                </td>
                                <td>
                                <?php echo $checked; ?>
                                </td>
                                <td align=left>
                                <?php echo $row->member_reg_no; ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" class="underline">
                                <?php echo $row->firm_name ; ?>
                                </a>
                                </td>
                                <td >
                                <?php echo $row->representative_title." ".$row->representative_name." ".$row->representative_last_name; ?>
                                </a>
                                </td>

                                <td >
                                <?php echo $row->type ; ?>
                                </a>
                                </td>
                                <?php
                                $k = 1 - $k;
                                ?>
                        </tr>
                        <?php
                }
                ?>
                </table>

                <?php echo $pageNav->getListFooter(); ?>

                <input type="hidden" name="option" value="com_member_group_town_scci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

        /**
        * Writes the edit form for new and existing categories
        * @param mosCategory The category object
        * @param string
        * @param array
        */
        function edit( &$row, &$lists , $id, $start_date, $end_date) {
                global $mosConfig_absolute_path,$mosConfig_live_site,$mosconfig_calender_date_format;
                //mosMakeHtmlSafe( $row, ENT_QUOTES, 'comments' );
                ?>
                <script language="javascript" type="text/javascript">

                    var arr = new Array();
                   arr[27] ="0";
                   arr[28] ="1";
                   arr[29] ="2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_IntNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 37; j++)
                      {
                        if(str.charAt(i) == arr[j])
                           break;
                      }
                      if(j>36)
                      {

                        alert(msg);
                        var temp = parseInt(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                          form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        form.elements[obj].select();
                        break;
                      }
                   }
                }

                 function copy_propietor_information(){
                         var form = document.adminForm;
                        if (form.check_propietor_information.checked==true){
                                form.representative_title.value="";
                                form.representative_name.value="";
                                form.representative_last_name.value="";
                                form.representative_designation.value="";
                                //alert(form.elements['up_file[]'][0].value);
                                form.representative_title.value=form.applicant_title.value;
                                form.representative_name.value=form.applicant_name.value;
                                form.representative_last_name.value=form.applicant_last_name.value;
                                form.representative_designation.value=8;
                        }
                }



                function copy_firm_address(){
                         var form = document.adminForm;
                        if (form.check_firm_address.checked==true){
                                form.head_office_address_street.value="";
                                form.head_office_address_town_suburb.value="";
                                form.head_office_address_district.value="";
                                form.head_office_address_division.value="";
                                form.head_office_address_country.value="";
                                form.head_office_phone.value="";
                                form.head_office_fax.value="";
                                form.head_office_mobile.value="";
                                form.head_office_email.value="";
                                form.head_office_web.value="";

                                form.head_office_address_street.value=form.firm_reg_address_street.value;
                                form.head_office_address_town_suburb.value=form.firm_reg_address_town_suburb.value;
                                form.head_office_address_district.value=form.firm_reg_address_district.value;
                                form.head_office_address_division.value=form.firm_reg_address_division.value;
                                form.head_office_address_country.value=form.firm_reg_address_country.value;
                                form.head_office_phone.value=form.firm_phone.value;
                                form.head_office_fax.value=form.firm_fax.value;
                                form.head_office_mobile.value=form.firm_mobile.value;
                                form.head_office_email.value=form.firm_email.value;
                                form.head_office_web.value=form.firm_web.value;
                        }
                }


                function echeck(str) {

                var at="@";
                var dot=".";
                var lat=str.indexOf(at);
                var lstr=str.length;
                var ldot=str.indexOf(dot);

                if (str.indexOf(at)==-1){
                   alert("Invalid E-mail ID");
                   return false;
                }

                else if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
                   alert("Invalid E-mail ID");
                   return false;
                }

                else if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
                    alert("Invalid E-mail ID");
                    return false;
                }

                 else if (str.indexOf(at,(lat+1))!=-1){
                    alert("Invalid E-mail ID");
                    return false;
                 }

                 else if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
                    alert("Invalid E-mail ID");
                    return false;
                 }

                 else if (str.indexOf(dot,(lat+2))==-1){
                    alert("Invalid E-mail ID");
                    return false;
                 }

                 else if (str.indexOf(" ")!=-1){
                    alert("Invalid E-mail ID");
                    return false;
                 }

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
                /*if(strYear){
                      if (strYear.length == 2 ) {
                      strYear = '20' + strYear;
                      }
               } */
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
                function LeapYear(intYear) {
                if (intYear % 100 == 0) {
                if (intYear % 400 == 0) { return true; }
                }
                else {
                if ((intYear % 4) == 0) { return true; }
                }
                return false;
                }
                function doDateCheck(from, to) {
                if (Date.parse(from.value) <= Date.parse(to.value)) {
                alert("The dates are valid.");
                }
                else {
                if (from.value == "" || to.value == "")
                alert("Both dates must be entered.");
                else
                alert("To date must occur after the from date.");
                   }
                }


//  End -->
                var newWin;
                 function newwindow_money_receipt(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                      page='../popup/moneyReceipt_popup.php?money_receipt_no='+document.adminForm.money_receipt_no.value+'&formName=adminForm';
                      newWin=window.open(page,'','width=425,height=130,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      newWin.focus();
               }
                function newwindow(from){
                         var form = document.adminForm;
                         if (form.type_id.value=="" || form.type_id.value==0){
                             alert('You must select member type.');
                             return false;
                         }
                         var reg_year_id="<?php echo $_SESSION['last_reg_year_id'];?>";
                         if (null != newWin && !newWin.closed)
                             closeNewWindow();
                         page='../popup/proposer_info_scci.php?from='+from+'&formName=adminForm'+'&amp;member_type='+form.type_id.value+'&amp;reg_year_id='+reg_year_id;
                         newWin=window.open(page,'','width=399,height=120,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                         newWin.focus();

               }
                 function belongs_to(){
                         var form = document.adminForm;
                        if ((form.proposer1_firm_name.value!="" && form.popup.value > 0) || (form.proposer2_firm_name.value!="" && form.popup.value > 0)){
                           if (confirm('You will lost proposer and seconder information. Do you want to change member type.?')){
                              //if (form.popup.value ==1){
                                 form.proposer1_name.value="";
                                 form.proposer1_last_name.value="";
                                 form.proposer1_firm_name.value="";
                                 form.proposer1_address.value="";
                                 form.proposer1_member_reg_no.value="";
                              //}
                              //if (form.popup.value ==2){
                                  form.proposer2_name.value="";
                                  form.proposer2_last_name.value="";
                                  form.proposer2_firm_name.value="";
                                  form.proposer2_address.value="";
                                  form.proposer3_member_reg_no.value="";
                              //}
                              form.popup.value=0;
                              return false;
                           }
                           else{
                               form.type_id.value=form.popup_type_id.value;
                               return true;
                           }
                        }
                }
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var start, end, reg;

                         var img=form.elements['up_file[]'][0].value;
                           var len=img.length;

                           var img_representative=form.elements['up_file[]'][1].value;
                           var len_representative=img_representative.length;

                           img=img.substr(len-3,3);
                           img_representative=img_representative.substr(len_representative-3,3);

                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        reg   =trim(form.reg_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);
                        //alert(form.check_firm_address.value);
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                       else if(form.type_id.value == "0"){
                            alert("You must select member type ");
                            form.type_id.focus();
                        }
                        else if(form.last_reg_year_id.value == "0" ){
                            alert("Registration year cannot be blank");
                            form.last_reg_year_id.focus();
                        }
                        else if(form.member_reg_no.value == "" ){
                            alert("Membership code cannot be blank");
                            form.member_reg_no.focus();
                        }
                        else if(form.reg_date.value == "0000-00-00" || form.reg_date.value ==""  || checkdate(form.reg_date)==false){
                            alert("Enter valid registration date");
                            form.reg_date.focus();
                        }
                        else if(!(reg.getTime()>=start.getTime() && reg.getTime()<=end.getTime())){
                            alert("Registration date must be between "+form.start_date.value+" and "+form.end_date.value);
                            form.reg_date.focus();
                        }
                        else if(form.money_receipt_no.value == "" ){
                            alert("Money receipt No. cannot be blank");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value =="" || checkdate(form.money_receipt_date)==false){
                            alert("Enter valid money receipt date");
                            form.money_receipt_date.focus();
                        }
                        else if(form.location.value == 0 ){
                            alert("You must select a location for member");
                            form.location.focus();
                        }
                        else if(form.firm_name.value == ""){
                            alert("The name of firm cannot be blank");
                            form.firm_name.focus();
                        }
                        else if(form.firm_reg_address_street.value == ""){
                            alert("Street/ area of firm cannot be blank ");
                            form.firm_reg_address_street.focus();
                        }
                        else if((form.firm_email.value!="") && (form.firm_email.value.indexOf('@', 0) == -1 || form.firm_email.value.indexOf('.', 0) == -1)){
                            alert("Enter valid e-mail address");
                            form.firm_email.focus();
                        } /*
                        else if(form.head_office_address_street.value == ""){
                            alert("Enter Head Office Street/ Area ");
                            form.head_office_address_street.focus();
                        }  */
                        else if((form.head_office_email.value!="") && (form.head_office_email.value.indexOf('@', 0) == -1 || form.head_office_email.value.indexOf('.', 0) == -1)){
                            alert("Enter valid e-mail address");
                            form.head_office_email.focus();
                        }
                       else if(form.applicant_name.value == ""){
                               alert("First name of proprietor cannot be blank");
                               form.applicant_name.focus();
                           }
                           else if(form.applicant_designation.value == "0"){
                               alert("You must enter designation of proprietor");
                               form.applicant_designation.focus();
                           }
                           else if(form.id.value==0 && form.elements['up_file[]'][0].value == ""){
                               alert("Photograph of proprietor cannot be blank");
                               form.elements['up_file[]'][0].focus();
                           }
                           else if(form.id.value==0 && form.elements['up_file[]'][0].value != "" && img!="jpg"){
                               alert("Enter valid image");
                               form.elements['up_file[]'][0].focus();
                           }
                           else if(form.representative_name.value == ""){
                               alert("First name of representative cannot be blank");
                               form.representative_name.focus();
                           }
                           else if(form.representative_designation.value == "0"){
                               alert("You must enter designation of representative");
                               form.representative_designation.focus();
                           }
                           else if(form.check_propietor_information.checked==false && form.id.value==0 && form.elements['up_file[]'][1].value == ""){
                               alert("Photograph of representative cannot be blank");
                               form.elements['up_file[]'][1].focus();
                           } //form.check_firm_address.value!=on &&
                           else if((form.id.value==0 && form.elements['up_file[]'][1].value != "" && img_representative!="jpg")){
                               alert("Enter valid image");
                               form.elements['up_file[]'][1].focus();
                           }
                        else if(form.proposer1_name.value == ""){
                            alert("First name of proposer cannot be blank");
                            form.proposer1_name.focus();
                        }
                        else if(form.proposer1_firm_name.value == ""){
                            alert("The firm's name of Proposer cannot be blank");
                            form.proposer1_firm_name.focus();
                        }
                        else if(form.proposer1_member_reg_no.value == ""){
                            alert("The Registration code of proposer cannot be blank");
                            form.proposer1_member_reg_no.focus();
                        }
                        else if(form.proposer2_name.value == ""){
                            alert("First name of seconder cannot be blank");
                            form.proposer2_name.focus();
                        }
                        else if(form.proposer2_firm_name.value == ""){
                            alert("The firm's name of Seconder cannot be blank");
                            form.proposer2_firm_name.focus();
                        }
                        else if(form.proposer2_member_reg_no.value == ""){
                            alert("The Registration code of seconder cannot be blank");
                            form.proposer2_member_reg_no.focus();
                        }
                        else if (form.firm_email.value != "" && echeck(form.firm_email.value)==false){
                              form.firm_email.focus();
                        }
                        else if (form.head_office_email.value != "" && echeck(form.head_office_email.value)==false){
                              form.head_office_email.focus();
                        }
                        else {
                                submitform( pressbutton );
                        }
                }




                </script>

                <form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Group/ Town Association :
                        <small>
                        <?php echo $row->id ? 'Edit' : 'New';  ?>
                        </small>
                        </th>
                </tr>
                </table>

                <table width="100%">
                <tr>
                        <td valign="top" width="100%">
                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        Group/ Town Association  <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>
                                <tr>
                                <td width=50%>
                                <table width=100%>
                                <tr width=100%>
                                        <td  width="30%" align="right">
                                        * Member Type :
                                        </td>
                                        <td width="70%">
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Year :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['last_reg_year_id']; ?>

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Membership Code :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $row->member_reg_no; ?>" size="30" maxlength="10" onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid Membership Code');" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Date :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->reg_date); ?>" size="20"   onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $row->money_receipt_no; ?>" size="20" maxlength="15"  />
                                        &nbsp;<a href="javascript:newwindow_money_receipt();" style="text-decoration:underline;">Check Money Receipt Number</a>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Money Receipt Date :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->money_receipt_date); ?>" size="20"   onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img3" border=0 class="calender_link">
                                        <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                        </td>
                                </tr>


                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Location :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['location']; ?>

                                        </td>
                                </tr>
                                </table>
                                </td>
                                <td width=50%>
                                <table width=100%>

                               <tr width=100%>
                                                    <td  align="right">
                                                    Type of Business :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="type_of_business" value="<?php echo $row->type_of_business; ?>" size="50" maxlength="125"  />
                                                    </td>
                                            </tr>

                                            <tr width=100%>
                                                <td  align="right">
                                                <div align=right> Date of Formation :</div>
                                                </td>
                                                <td >
                                                <input class="text_area" type="text" name="date_of_formation" id="date_of_formation" value="<?php echo mosHTML::ConvertDateDisplayShort($row->date_of_formation); ?>" size="20"   onBlur="checkdate(this)"    />
                                                <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                                <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                                </td>
                                            </tr>
                                <tr width=100%>
                                                    <td  align="right">
                                                    Rules of Managemant :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="rules_of_formation" value="<?php echo $row->rules_of_formation; ?>" size="50" maxlength="125"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Statement of Association :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="statement_of_association" value="<?php echo $row->statement_of_association; ?>" size="50" maxlength="125"  />
                                                    </td>
                                            </tr>

                                              <tr width=100%>
                                        <td  align="right">
                                        Name of the Bank :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bank_name" value="<?php echo $row->bank_name; ?>" size="50" maxlength="50"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bank_address" value="<?php echo $row->bank_address; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>
                                </table>
                                </td>
                                </tr>

                                <tr>
                                <td width=50%>
                                <table width=100%>

                                             <tr width=100%>
                                                     <td  align="center" colspan=2 valign=bottom height=26>
                                                     <b>Group/ Town Association Information</b>
                                                     </td>
                                             </tr>
                                             <tr width=100%>
                                                     <td  align="right" width=30%>
                                                     * Name of the Firm :
                                                     </td>
                                                     <td  width=70%>
                                                     <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm_name; ?>" size="50" maxlength="255"  />
                                                     </td>
                                             </tr>
                                             <tr width=100%>
                                                   <td  align="right" >
                                                   * Street/ Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="firm_reg_address_street" value="<?php echo $row->firm_reg_address_street; ?>" size="50" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana/ Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_town_suburb" value="<?php echo $row->firm_reg_address_town_suburb; ?>" size="18" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   <input class="text_area" type="text" name="firm_reg_address_district" value="<?php echo $row->firm_reg_address_district; ?>" size="18" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_division" value="<?php echo $row->firm_reg_address_division; ?>" size="18" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   <input class="text_area" type="text" name="firm_reg_address_country" value="<?php echo $row->firm_reg_address_country; ?>" size="18" maxlength="30"  />
                                                   </td>
                                           </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Phone :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $row->firm_phone; ?>" size="18" maxlength="50"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                                    <input class="text_area" type="text" name="firm_fax" value="<?php echo $row->firm_fax; ?>" size="18" maxlength="125"  />
                                                    </td>
                                            </tr>

                                            <tr width=100%>
                                                    <td  align="right">
                                                    Mobile :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_mobile" value="<?php echo $row->firm_mobile; ?>" size="50" maxlength="50"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Email address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_email" value="<?php echo $row->firm_email; ?>" size="50" maxlength="125"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Web address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_web" value="<?php echo $row->firm_web; ?>" size="50" maxlength="125"  />
                                                    </td>
                                            </tr>
                                </table>
                                </td>
                                <td width=50%>
                                <table width=100%>

                               <tr width=100%>
                                                   <td  align="center" colspan=2 valign=bottom height=20>
                                                  <b>Head Office/ Mailimg Information </b>
                                                  &nbsp; <input class="text_area" type="checkbox" name="check_firm_address" onClick="javascript:copy_firm_address();" />  Copy Group/Town Association Information
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right"  width=30%>
                                                  Street/ Area :
                                                   </td>
                                                   <td  width=70%>
                                                   <input class="text_area" type="text" name="head_office_address_street" value="<?php echo $row->head_office_address_street; ?>" size="50" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana/ Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="head_office_address_town_suburb" value="<?php echo $row->head_office_address_town_suburb; ?>" size="18" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   <input class="text_area" type="text" name="head_office_address_district" value="<?php echo $row->head_office_address_district; ?>" size="18" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="head_office_address_division" value="<?php echo $row->head_office_address_division; ?>" size="18" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   <input class="text_area" type="text" name="head_office_address_country" value="<?php echo $row->head_office_address_country; ?>" size="18" maxlength="30"  />
                                                   </td>
                                           </tr>
                                        <tr width=100%>
                                        <td  align="right">
                                        Phone :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_phone" value="<?php echo $row->head_office_phone; ?>" size="18" maxlength="50"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                        <input class="text_area" type="text" name="head_office_fax" value="<?php echo $row->head_office_fax; ?>" size="18" maxlength="125"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_mobile" value="<?php echo $row->head_office_mobile; ?>" size="50" maxlength="50"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Email address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_email" value="<?php echo $row->head_office_email; ?>" size="50" maxlength="125"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Web address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_web" value="<?php echo $row->head_office_web; ?>" size="50" maxlength="125"  />
                                        </td>
                                </tr>
                                </table>
                                </td>
                                </tr>

                                <tr>
                                <td width=50%>
                                <table width=100%>
                                <tr width=100%>
                                        <td  align="center" colspan=2>
                                        <b>Proprietor Information </b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right" width="30%">
                                        Title :
                                        </td>
                                        <td width=70%>
                                        <?php echo $lists['applicant_title']; ?>

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right" >
                                        * First Name :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="applicant_name" value="<?php echo $row->applicant_name; ?>" size="50" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right" >
                                        Last Name :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="applicant_last_name" value="<?php echo $row->applicant_last_name; ?>" size="50" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="applicant_designation" value="<?php  echo $_SESSION['applicant_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['applicant_designation']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <?php echo intval($id)?"":"*"; ?> Photograph :
                                        </td>
                                        <td >
                                        <input class="text_area" type="file" name="up_file[]" size=25  />
                                        <?php echo mosToolTip('Image Format : .jpg '); ?>
                                        </td>
                                </tr>
                                </table>
                                </td>
                                <td width=50% align=right>
                                <table width=100%>

                                <tr >
                                        <td  align="center" colspan=2>
                                        <b>Representative Information</b>
                                        &nbsp; <input class="text_area" type="checkbox" name="check_propietor_information" onClick="javascript:copy_propietor_information();" /> Copy Proprietor Information
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" width="30%">
                                        Title :
                                        </td>
                                        <td width=70%>

                                        <?php echo $lists['representative_title']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        * First Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="representative_name" value="<?php echo $row->representative_name; ?>" size="50" maxlength="25"  />

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="representative_last_name" value="<?php echo $row->representative_last_name; ?>" size="50" maxlength="25"  />

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="representative_designation" value="<?php echo $_SESSION['representative_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['representative_designation']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <?php echo intval($id)?"":"*"; ?> Photograph :
                                        </td>
                                        <td >
                                        <input class="text_area" type="file" name="up_file[]" size=25  />
                                        <?php echo mosToolTip('Image Format : .jpg '); ?>
                                        </td>
                                </tr>
                                </table>
                                </td>
                                </tr>

                                <tr>
                                <td width=50%>
                                <table width=100%>

                                <tr width=100%>
                                        <td  align="center" colspan=2>
                                        <b>Proposer Information</b>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" width=30%>
                                        Title :
                                        </td>
                                        <td width=70%>
                                        <?php echo $lists['proposer1_title']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * First Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer1_name" value="<?php echo $row->proposer1_name; ?>" size="50" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer1_last_name" value="<?php echo $row->proposer1_last_name; ?>" size="50" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        * Name of the Firm :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer1_firm_name" value="<?php echo $row->proposer1_firm_name; ?>" size="50" maxlength="150"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        Address :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer1_address" value="<?php echo $row->proposer1_address; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Membership Code :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer1_member_reg_no" value="<?php echo $row->proposer1_member_reg_no; ?>" size="50" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Proposer' onclick=javascript:newwindow(1); />
                                                        </td>
                                 </tr>
                                </table>
                                </td>
                                <td width=50%>
                                <table width=100%>

                                <tr width=100%>
                                        <td  align="center" colspan=2>
                                        <b>Seconder Information</b>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" width=30%>
                                        Title :
                                        </td>
                                        <td width=70%>
                                        <?php echo $lists['proposer2_title']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * First Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer2_name" value="<?php echo $row->proposer2_name; ?>" size="50" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer2_last_name" value="<?php echo $row->proposer2_last_name; ?>" size="50" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        * Name of the Firm :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer2_firm_name" value="<?php echo $row->proposer2_firm_name; ?>" size="50" maxlength="150"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        Address :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer2_address" value="<?php echo $row->proposer2_address; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Membership Code :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer2_member_reg_no" value="<?php echo $row->proposer2_member_reg_no; ?>" size="50" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Seconder' onclick=javascript:newwindow(2); />
                                                        </td>
                                 </tr>
                                </table>
                                </td>
                                </tr>

                </td>
                </table>
                </td>
                </tr>
                </table>

                <input type="hidden" name="option" value="com_member_group_town_scci" />
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0" />
                <input type="hidden" name="popup" value="0">
                <input type="hidden" name="popup_type_id" value="0">
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "reg_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "date_of_formation",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                        Calendar.setup({
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img3",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <?php
        }

}
?>
