<?php
/**
* @version $Id: admin.membership_ccci.html.php,v 1.49 2006/12/21 11:53:06 morshed Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Weblinks
*/
class HTML_Membership {

        function showMembership( $option, &$rows, &$lists, &$search, &$pageNav ) {
                global $my;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th>
                        Member Profile
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
                </table>

                <table class="adminlist">
                <tr>
                        <th width="5">
                        #
                        </th>
                        <th width="20">
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
                        </th>
                        <th class="firmname" width=35% align="left">
                        Firm Name
                        </th>
                        <th class="name" align="left" width=30%>
                        Applicant Name
                        </th>
                        <th class="type" align="left" with=25%>
                        Member Type
                        </th>
                        <th class="type" align="center" with=10%>
                        Membership No.
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];

                        $link         = 'index2.php?option=com_membership_edit_ccci&task=editA&hidemainmenu=1&id='. $row->id;


                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                    ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <td>
                                <?php echo $checked; ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" title="Edit Member Profile">
                                <?php echo stripslashes($row->firm_name); ?>
                                </a>
                                </td>
                                <td>
                                <?php echo stripslashes($row->applicant_title)." ".stripslashes($row->applicant_name)." ".stripslashes($row->applicant_last_name); ?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->type); ?>
                                </td>
                                <td align=center>
                                <?php echo stripslashes($row->member_reg_no); ?>
                                </td>
                        </tr>
                        <?php
                        $k = 1 - $k;
                }
                ?>
                </table>
                <?php echo $pageNav->getListFooter(); ?>
                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="step" value="0" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0">
                </form>
                <?php
        }

        /**
        * Writes the edit form for new and existing record
        *
        * A new record is defined when <var>$row</var> is passed with the <var>id</var>
        * property set to 0.
        * @param mosWeblink The weblink object
        * @param array An array of select lists
        * @param object Parameters
        * @param string The option
        */
         function editMembership( &$lists, $option, $id, $start_date, $end_date, &$max_reg_no  ) {
                global $mosConfig_live_site,$mosconfig_calender_date_format;
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

                function copy_firm_address(e){
                   var form = document.adminForm;
                   var keyPressed;
                   if (document.all)
                   {
                       keyPressed = e.keyCode;
                   }
                   else
                   {
                       keyPressed = e.which;
                   }
                   if(keyPressed==13 || form.check_firm_address.checked==true)
                   {
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
                          return;
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
                                form.representative_designation.value=form.applicant_designation.value;
                                //form.elements['up_file[]'][1].value=form.elements['up_file[]'][0].value;


                        }
                        /*else if (form.check_propietor_information.checked==false){
                                form.representative_title.value="";
                                form.representative_name.value="";
                                form.representative_last_name.value="";
                                form.representative_designation.value="";
                                //form.elements['up_file[]'][1].value="";

                        } */
                }

                 function belongs_to(){
                         var form = document.adminForm;
                         var belongsto=form.type_id.value;
                         /*
                        if ((form.proposer_1_firm_name.value!="" && form.popup.value > 0) || (form.proposer_2_firm_name.value!="" && form.popup.value > 0)){
                           if (confirm('You will lost proposer and seconder information. Do you want to change member type.?')){
                              if (form.popup.value ==1){
                                 form.proposer_1_name.value="";
                                 form.proposer_1_last_name.value="";
                                 form.proposer_1_firm_name.value="";
                                 form.proposer_1_designation.value=0;
                              }
                              if (form.popup.value ==2){
                                  form.proposer_2_name.value="";
                                  form.proposer_2_last_name.value="";
                                  form.proposer_2_firm_name.value="";
                                  form.proposer_2_designation.value=0;
                              }
                              form.popup.value=0;
                              return false;
                           }
                           else{
                               form.type_id.value=form.popup_type_id.value;
                               return true;
                           }
                        }
                         */

                        if (belongsto==5){
                            document.getElementById('belongsto').style.display='inline';
                            document.getElementById('representative_title').style.display='inline';
                            document.getElementById('representative_information').style.display='inline';
                            document.getElementById('representative_designation_information').style.display='inline';
                            document.getElementById('nominee').style.display='none';
                            document.getElementById('proposer').style.display='none';
                            return true;
                        }
                        else{
                            document.getElementById('belongsto').style.display='none';
                            document.getElementById('representative_title').style.display='none';
                            document.getElementById('representative_information').style.display='none';
                            document.getElementById('representative_designation_information').style.display='none';
                            document.getElementById('nominee').style.display='inline';
                            document.getElementById('proposer').style.display='inline';
                            return true;
                        }
                }

                function corporate(){
                        var form = document.adminForm;
                         var corporate=form.corporate_status.value;

                        if (trim(corporate)=="Limited Company"){
                            document.getElementById('memorandum_article').style.display='inline';
                            document.getElementById('partnership_deed').style.display='none';
                            return true;
                        }
                        else if (trim(corporate)=="Partnership"){
                            document.getElementById('memorandum_article').style.display='none';
                            document.getElementById('partnership_deed').style.display='inline';
                            return true;
                        }
                        else{
                            document.getElementById('memorandum_article').style.display='none';
                            document.getElementById('partnership_deed').style.display='none';
                            return true;
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
                //var newWin;
                function newwindow(from){
                         var form = document.adminForm;
                         /*
                         if (form.type_id.value=="" || form.type_id.value==0){
                             alert('You must select member type.');
                             return false;
                         }
                         */
                         var reg_year_id="<?php echo $_SESSION['last_reg_year_id'];?>";
                         if (null != newWin && !newWin.closed)
                             closeNewWindow();
                         page='../popup/proposer_info_ccci.php?from='+from+'&formid=0'+'&amp;member_type='+form.type_id.value+'&amp;reg_year_id='+reg_year_id;
                         newWin=window.open(page,'','width=500,height=150,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                         newWin.focus();

               }

                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                         var opt=pressbutton;
                        var start, end, reg;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        reg   =trim(form.reg_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);
                        var issue, expire;
                        issue =trim(form.trade_licence_issue_date.value);
                        expire =trim(form.trade_licence_expire_date.value);
                        issue=new Date(issue.split('-')[2],issue.split('-')[1],issue.split('-')[0]);
                        expire=new Date(expire.split('-')[2],expire.split('-')[1],expire.split('-')[0]);

                        var img=form.elements['up_file'].value;
                        var len=img.length;
                        img1=img.substr(len-3,3);
                        img2=img.substr(len-4,4);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(form.type_id.value == "0"){
                            alert("You must select member type ");
                            form.type_id.focus();
                        }
                        else if(form.type_id.value == "5" && form.parent.value == "0"){
                            alert("You must select belongs to ");
                            form.parent.focus();
                        }
                        else if(form.last_reg_year_id.value == "0" ){
                            alert("Registration year cannot be blank");
                            form.last_reg_year_id.focus();
                        }   /*
                        else if(form.member_reg_no.value == "" ){
                            alert("Member registered no can't be blank");
                            form.member_reg_no.focus();
                        }  */
                        else if(form.reg_date.value == "0000-00-00" || form.reg_date.value ==""  || checkdate(form.reg_date)==false){
                            alert("Enter valid registration date");
                            form.reg_date.focus();
                        }

                        else if(reg.getTime()<start.getTime() || reg.getTime()>end.getTime()){
                            alert("Registration date must be between "+form.start_date.value+" and "+form.end_date.value);
                            form.reg_date.focus();
                        }
                        else if(form.money_receipt_no.value == "" ){
                            alert("Money receipt No. cannot be blank");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value ==""  || checkdate(form.money_receipt_date)==false){
                            alert("Enter valid money receipt date");
                            form.money_receipt_date.focus();
                        }

                        else if(form.corporate_status.value == "0"){
                            alert("You must select corporate status");
                            form.corporate_status.focus();
                        }/*
                         else if (form.corporate_status.value == "Limited Company" && form.is_memorandum_article[1].checked == false){
                                     alert("Memorandum and Article of Association essential for Limited Company");
                                     form.is_memorandum_article[1].focus();
                        }
                        else if (form.corporate_status.value == "Partnership" && form.is_partnership_deed[1].checked == false){
                                     alert("Partnership Deed essential");
                                     form.is_partnership_deed[1].focus();
                        }*/
                        else if(form.applicant_name.value == ""){
                               alert("Name of the applicant cannot be blank");
                               form.applicant_name.focus();
                        }
                        else if(form.applicant_designation.value == "0"){
                               alert("You must enter designation");
                               form.applicant_designation.focus();
                        }  /*
                           else if(form.elements['up_file'].value == ""){
                               alert("Photograph of applicant can't be blank");
                               form.elements['up_file'].focus();
                           }     */
                        else if(form.elements['up_file'].value != ""  && img1.toLowerCase()!="jpg" && img2.toLowerCase()!="jpeg"){
                               alert("Enter valid image");
                               form.elements['up_file'].focus();
                        }
                        else if(form.firm_name.value == ""){
                            alert("Name of the firm cannot be blank");
                            form.firm_name.focus();
                        }
                         else if(form.firm_reg_address_street.value == ""){
                            alert("Enter Firm's Street Address ");
                            form.firm_reg_address_street.focus();
                        }
                           else if (form.firm_email.value != "" && echeck(form.firm_email.value)==false){
                              form.firm_email.focus();
                           }
                           else if (form.head_office_email.value != "" && echeck(form.head_office_email.value)==false){
                              form.head_office_email.focus();
                           }
                        
                        else if(form.trade_licence_no.value == ""){
                               alert("Trade license No. cannot be blank");
                               form.trade_licence_no.focus();
                        }
                         else if(form.trade_licence_issued_by.value == ""){
                               alert("Authority of trade license cannot be blank");
                               form.trade_licence_issued_by.focus();
                        }
                         else if(form.trade_licence_issue_date.value == ""  || checkdate(form.trade_licence_issue_date)==false){
                               alert("Trade license issue date cannot be blank");
                               form.trade_licence_issue_date.focus();
                        }
                        else if(form.trade_licence_expire_date.value == ""  || checkdate(form.trade_licence_expire_date)==false){
                               alert("Trade license expiry date cannot be blank");
                               form.trade_licence_expire_date.focus();
                        }
                        else if(issue.getTime()>=expire.getTime()){
                            alert("Trade license issue date "+form.trade_licence_issue_date.value+" must be less than trade license expiry date "+form.trade_licence_expire_date.value);
                            form.trade_licence_issue_date.focus();
                        }
                        
                        else if(form.tin.value == ""){
                               alert("Tax payers identification No. cannot be blank");
                               form.tin.focus();
                        }  /*
                        else if(form.type_id.value!=5 && form.proposer_1_firm_name.value == ""){
                            alert("The proposer's firm's name cannot be blank");
                            form.proposer_1_firm_name.focus();
                        }
                        else if(form.type_id.value!=5 && form.proposer_2_firm_name.value == ""){
                            alert("The seconder's firm's name cannot be blank");
                            form.proposer_2_firm_name.focus();
                        }
                        */else if(form.type_id.value!=5 && form.principal_nominee_name.value == ""){
                               alert("Principal nominee's name cannot be blank");
                               form.principal_nominee_name.focus();
                           }else if(form.type_id.value!=5 && form.principal_nominee_designation.value == ""){
                               alert("Select principal nominee's designation");
                               form.principal_nominee_designation.focus();
                           }

                        else{
                                submitform( pressbutton );
                        }

                }
                </script>
                <form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                <table class="adminheading">
                <tr>
                        <th >
                        Member Information :
                        <small>
                        <?php echo $id ? 'Edit' : 'New'; ?>
                        </small>
                        </th>
                </tr>
                </table>
                <table width="100%">
                <tr>
                        <td width="100%" valign="top">
                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        Details <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>

                               <!-- modified by mizan start-->
                               <tr width=100% >
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr><td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->

                               <tr width=100%>
                                        <td  width="35%" align="right" >
                                        * Member Type :
                                        </td>
                                        <td width="65%">
                                        <?php echo $lists['type_id'];
                                        ?>
                                        </td>
                                </tr>
                                <tr width="100%" id="belongsto">
                                        <td  align="right">
                                        * Belongs To :
                                        </td>
                                        <td >
                                        <?php echo $lists['parent']; ?>
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
                                        <td  align="right" height=24 nowrap>
                                        Last Membership No :
                                        </td>
                                        <td >

                                        <?php

                                        echo "&nbsp;Associate - ".intval($max_reg_no[1]).", Ordinary - ".intval($max_reg_no[0]).", Delegate - ".intval($max_reg_no[2]); ?>

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Membership No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $row->member_reg_no; ?>" size="27" maxlength="20"  onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid Membership Number');" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Date :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->reg_date); ?>" size="20"    onBlur="checkdate(this)"  />
                               Chittagong City Corporation         <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <!--?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?-->
                                         (dd-mm-yyyy)
                                        </td>
                                </tr>
                                 <tr width=100% >
                                        <td  align="right">
                                        Is Oustside City :
                                        </td>
                                        <td >
                                        <?php echo $lists['is_outside']; ?>
                                        </td>
                                </tr>

                                 <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->

                                 <tr width=100%>
                                        <td  align="right" width="40%">
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $row->money_receipt_no; ?>" size="27" maxlength="15"  />
                                        &nbsp;<a href="javascript:newwindow_money_receipt();" style="text-decoration:underline;">Check Money Receipt Number</a>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Money Receipt Date :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->money_receipt_date); ?>" size="20"   onBlur="checkdate(this)"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        <!--?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?-->
                                         (dd-mm-yyyy)
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td align="right">
                                        Establishment Year :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="establishment_year" value="<?php echo $row->establishment_year; ?>" size="27" maxlength="6"  />
                                        </td>
                                </tr>


                                <tr width=100%>
                                        <td  align="right" >
                                         * Corporate Status :
                                        </td>
                                        <td >
                                        <?php echo $lists['corporate_status'];
                                        ?>
                                        </td>
                                </tr>
                                <tr width="100%" id="memorandum_article">
                                        <td align="right">
                                        Is Memorandum and Article of Association :
                                        </td>
                                        <td>
                                        <?php echo $lists['is_memorandum_article']; ?>
                                        </td>
                                </tr>

                                <tr width="100%" id="partnership_deed">
                                        <td align="right">
                                        Is Partnership Deed :
                                        </td>
                                        <td>
                                        <?php echo $lists['is_partnership_deed']; ?>
                                        </td>
                                </tr>
                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>
                                <!-- modified by mizan end-->


                                <!-- Modified by mizan start-->
                                 <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <b>Applicant Information</b>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td align="right" width="25%">
                                        [ * Name of the Applicant ] Title :
                                        </td>
                                        <td>
                                        <?php echo $lists['applicant_title']; ?>
                                        &nbsp; First Name :&nbsp;
                                        <input class="text_area" type="text" name="applicant_name" value="<?php echo $row->applicant_name; ?>" size="20" maxlength="25"  />
                                        &nbsp; Last Name :&nbsp;
                                         <input class="text_area" type="text" name="applicant_last_name" value="<?php echo $row->applicant_last_name; ?>" size="20" maxlength="25"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        * Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="applicant_designation" value="<?php  echo $_SESSION['applicant_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['applicant_designation']; ?>
                                        &nbsp;Photograph :&nbsp;
                                        <input class="text_area" type="file" name="up_file" size=25 value="15" />
                                        <?php echo mosToolTip('Image Format : .jpg, .jpeg '); ?>
                                        </td>
                                </tr>


                                <tr width="100%" id="representative_title">
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <input class="text_area" type="checkbox" name="check_propietor_information" onClick="javascript:copy_propietor_information();" />
                                        &nbsp;<b>Representative Information</b>
                                        </td>
                                </tr>


                                <tr width="100%" id="representative_information">
                                        <td  align="right">
                                         [ Name of The Representative ] Title :
                                        </td>
                                        <td >
                                        <?php echo $lists['representative_title']; ?>
                                        &nbsp;  First Name :&nbsp;
                                        <input class="text_area" type="text" name="representative_name" value="<?php echo $row->representative_name; ?>" size="20" maxlength="25"  />
                                        &nbsp;  Last Name :&nbsp;
                                        <input class="text_area" type="text" name="representative_last_name" value="<?php echo $row->representative_last_name; ?>" size="20" maxlength="25"  />

                                        </td>
                                </tr>

                                <tr width="100%" id="representative_designation_information">
                                        <td  align="right">
                                         Designation :
                                        </td>
                                        <td >
                                        <?php echo $lists['representative_designation']; ?>
                                        </td>
                                </tr>
                                <tr width=100% >
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->

                                               <tr width=100%>
                                                       <td height=26 align="center" colspan=2 valign=bottom>
                                                       <b>Registered Information</b>
                                                       </td>
                                               </tr>
                                            <tr width=100%>
                                                    <td  align="right" width="30%">
                                                    * Name of the Firm :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm_name; ?>" size="54" maxlength="150"  />
                                                    </td>
                                            </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   * Street/ Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="firm_reg_address_street" value="<?php echo $row->firm_reg_address_street; ?>" size="54 maxlength="100" onkeypress="javascript:copy_firm_address(event);" />

                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana/ Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_town_suburb" value="<?php echo $row->firm_reg_address_town_suburb; ?>" size="20" maxlength="30" onkeypress="javascript:copy_firm_address(event);" />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   &nbsp;<input class="text_area" type="text" name="firm_reg_address_district" value="<?php echo $row->firm_reg_address_district; ?>" size="20" maxlength="30" onkeypress="javascript:copy_firm_address(event);" />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_division" value="<?php echo $row->firm_reg_address_division; ?>" size="20" maxlength="20" onkeypress="javascript:copy_firm_address(event);" />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   &nbsp;<input class="text_area" type="text" name="firm_reg_address_country" value="<?php echo $row->firm_reg_address_country; ?>" size="20" maxlength="30" onkeypress="javascript:copy_firm_address(event);" />
                                                   </td>
                                           </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Phone :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $row->firm_phone; ?>" size="20" maxlength="35" onkeypress="javascript:copy_firm_address(event);" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                                    &nbsp;<input class="text_area" type="text" name="firm_fax" value="<?php echo $row->firm_fax; ?>" size="20" maxlength="20" onkeypress="javascript:copy_firm_address(event);" />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Mobile :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_mobile" value="<?php echo $row->firm_mobile; ?>" size="54" maxlength="35" onkeypress="javascript:copy_firm_address(event);" />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Email address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_email" value="<?php echo $row->firm_email; ?>" size="54" maxlength="125" onkeypress="javascript:copy_firm_address(event);" />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Web address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_web" value="<?php echo $row->firm_web; ?>" size="54" maxlength="125" onkeypress="javascript:copy_firm_address(event);" />
                                                    </td>
                                            </tr>

                                            <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->



                                         <tr width=100%>
                                          <td height=26 align="center" colspan=2 valign=bottom>
                                          <input class="text_area" type="checkbox" name="check_firm_address" onClick="javascript:copy_firm_address();" />
                                           &nbsp;<b>Head Office/ Factory Information</b>
                                          </td>
                                          </tr>
                                           <tr width=100%>
                                                   <td  align="right" width="25%">
                                                   Street/ Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="head_office_address_street" value="<?php echo $row->head_office_address_street; ?>" size="54" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana/ Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="head_office_address_town_suburb" value="<?php echo $row->head_office_address_town_suburb; ?>" size="20" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   &nbsp;<input class="text_area" type="text" name="head_office_address_district" value="<?php echo $row->head_office_address_district; ?>" size="20" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="head_office_address_division" value="<?php echo $row->head_office_address_division; ?>" size="20" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   &nbsp;<input class="text_area" type="text" name="head_office_address_country" value="<?php echo $row->head_office_address_country; ?>" size="20" maxlength="30"  />
                                                   </td>
                                           </tr>
                                        <tr width=100%>
                                        <td  align="right">
                                        Phone :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_phone" value="<?php echo $row->head_office_phone; ?>" size="20" maxlength="35"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                        &nbsp;<input class="text_area" type="text" name="head_office_fax" value="<?php echo $row->head_office_fax; ?>" size="20" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_mobile" value="<?php echo $row->head_office_mobile; ?>" size="54" maxlength="35"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Email address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_email" value="<?php echo $row->head_office_email; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Web address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_web" value="<?php echo $row->head_office_web; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>

                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>
                                <!-- modified by mizan end-->






                                <!-- Modified by mizan start-->

                                <tr width=100% >
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->


                                      <tr width="100%" height="24">
                                        <td align="center" colspan=2 valign="middle">
                                        <b>Trade License Information</b>
                                        </td>
                                </tr>

                                <!--tr width=100%>
                                        <td height=24 align="center" colspan=2 valign=bottom>
                                        <b>Money Receipt Information</b>
                                        </td>
                                </tr-->
                                 <tr width=100%>
                                        <td  align="right" width="30%">
                                        * License Number :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_no" value="<?php echo $row->trade_licence_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                  </tr>
                                  <tr width=100%>
                                        <td align="right">
                                        * Issuing Authority's Name :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="Chittagong City Corporation" size="54" maxlength="50"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        * Issue Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_issue_date" id="trade_licence_issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->trade_licence_issue_date); ?>" size="20" maxlength="20"   onBlur="checkdate(this)" />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
                                        <!--?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?-->
                                         (dd-mm-yyyy)
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Expiry Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_expire_date" id="trade_licence_expire_date" value="<?php echo $end_date; ?>" size="20" maxlength="20"   onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img5" border=0 class="calender_link">
                                        <!--?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?-->
                                         (dd-mm-yyyy)
                                        </td>
                                </tr>
                                 <tr width=100%>
                                <td  align="right">
                                        * TIN No. :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="tin" value="<?php echo $row->tin; ?>" size="54" maxlength="20"  />
                                        </td>
                                </tr>






                                            <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td valign="top" width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->

                                <tr width="100%" height="20">
                                        <td align="center" colspan="2" valign="bottom">

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        Importer Reg. No. :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="import_reg_no" value="<?php echo $row->import_reg_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                         <td  align="right">
                                        Exporter Reg. No. :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="export_reg_no" value="<?php echo $row->export_reg_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                </tr>
                                 <tr width="100%">
                                        <td  align="right">
                                        Indenting Trade No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="indenting_trade_no" value="<?php echo $row->indenting_trade_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                 </tr>
                                 <tr width=100%>
                                        <td  align="right" width="21%">
                                        Bank Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bank_name" value="<?php echo $row->bank_name; ?>" size="54" maxlength="50"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Bank Address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bank_address" value="<?php echo $row->bank_address; ?>" size="54" maxlength="255"  />
                                        </td>
                                </tr>






                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>
                                <!-- modified by mizan end-->






                              <tr width="100%" id="proposer">
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->


                                      <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <b>Proposer Information</b>
                                        </td>
                                </tr>


                                <tr width="100%">
                                        <td  align="right" width="30%">
                                        Title :
                                        </td>
                                        <td >
                                        <?php echo $lists['proposer_1_title']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        First Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_1_name" value="<?php echo $row->proposer_1_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_1_last_name" value="<?php echo $row->proposer_1_last_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td  align="right">
                                        Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="applicant_designation" value="<?php  echo $_SESSION['applicant_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['proposer_1_designation']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        Name of the Firm :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="proposer_1_firm_name" value="<?php echo $row->proposer_1_firm_name; ?>" size="54" maxlength="100"  />
                                        </td>
                                </tr>
                                 <!--tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Proposer' onclick=javascript:newwindow(1); />
                                                        </td>
                                 </tr-->




                                            <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td valign="top" width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->

                                 <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <b>Seconder Information</b>
                                        </td>
                                </tr>


                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        Title :
                                        </td>
                                        <td >
                                        <?php echo $lists['proposer_2_title']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        First Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_2_name" value="<?php echo $row->proposer_2_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_2_last_name" value="<?php echo $row->proposer_2_last_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                               <tr width=100%>
                                        <td  align="right">
                                        Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="applicant_designation" value="<?php  echo $_SESSION['applicant_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['proposer_2_designation']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        Name of the Firm :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="proposer_2_firm_name" value="<?php echo $row->proposer_2_firm_name; ?>" size="54" maxlength="100"  />
                                        </td>
                                </tr>
                                <!--tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Seconder' onclick=javascript:newwindow(2); />
                                                        </td>
                                 </tr-->




                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>

                                 <!-- Modified by mizan start-->

                                <tr width="100%" id="nominee">
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->


                                      <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <b>Principal Nominee Information</b>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td align="right" width="30%">
                                        Title :
                                        </td>
                                        <td>
                                        <?php echo $lists['principal_nominee_title']; ?>

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        * First Name :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="principal_nominee_name" value="<?php echo $row->principal_nominee_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        Last Name :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="principal_nominee_last_name" value="<?php echo $row->principal_nominee_last_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="applicant_designation" value="<?php  echo $_SESSION['applicant_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['principal_nominee_designation']; ?>
                                        </td>
                                </tr>

                                            <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td valign="top" width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->

                                 <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <b>Alternate Nominee Information</b>
                                        </td>
                                </tr>

                                <!--tr width=100%>
                                        <td  align="right" width="25%">
                                        * Representative Name :
                                        </td>
                                        <td >


                                        </td>
                                </tr-->
                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        Title :
                                        </td>
                                        <td >

                                        <?php echo $lists['alt_nominee_title']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        First Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="alt_nominee_name" value="<?php echo $row->alt_nominee_name; ?>" size="54" maxlength="25"  />

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="alt_nominee_last_name" value="<?php echo $row->alt_nominee_last_name; ?>" size="54" maxlength="25"  />

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="representative_designation" value="<?php echo $_SESSION['representative_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['alt_nominee_designation']; ?>
                                        </td>
                                </tr>

                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>
                                <!-- modified by mizan end-->



                                <!-- modified by mizan end-->
                              <tr width=100%>
                                        <td align="right">
                                        Business Type :
                                        </td>
                                        <td>
                                        <?php echo $lists['business_type']; ?>
                                        </td>
                                </tr>

                            </table>
                            </td>
                        </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="step" value="1" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0">
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


                </script>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>

                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "trade_licence_issue_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img4",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "trade_licence_expire_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img5",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <?php
        }


}
?>
