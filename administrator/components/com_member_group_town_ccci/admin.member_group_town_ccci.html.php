<?php
/**
* @version $Id: admin.member_group_town_ccci.html.php,v 1.21 2006/08/27 04:42:39 morshed Exp $
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
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                <tr>
                        <th>
                        Group and Town Association
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
                        <th width="5" align="left">
                        #
                        </th>

                        <th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th>

                        <th class="title" width=35%>
                        Firm Name
                        </th>



                        <th class="title" width=30% align=left>
                        Representative Name
                        </th>

                        <th class="title" width=20% align=left>
                        Member Type
                        </th>

                        <th class="title" align="center" with=15%>
                         Membership No.
                        </th>

                </tr>
                <?php
                $k = 0;

                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_member_group_town_ccci&task=editA&hidemainmenu=1&id='. $row->id;

                        $access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>

                                <td>
                                <?php echo $checked; ?>
                                </td>

                                <td>
                                <a href="<?php echo $link; ?>">
                                <?php echo $row->firm_name ; ?>
                                </a>
                                </td>

                                <td >
                                <?php echo stripslashes($row->representative_title)." ".stripslashes($row->representative)." ".stripslashes($row->representative_last_name); ?>
                                </td>

                                <td >
                                <?php echo $row->type ; ?>
                                </td>

                                 <td align="center">

                                <?php echo stripslashes($row->member_reg_no); ?>
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

                <input type="hidden" name="option" value="com_member_group_town_ccci" />
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
        function edit( &$row, &$lists , $id, $start_date, $end_date, &$max_reg_no) {
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
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var start, end, reg;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        reg   =trim(form.reg_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        else if(form.type_id.value == "0"){
                            alert("You must select Member Type ");
                            form.type_id.focus();
                        }
                        else if(form.last_reg_year_id.value == "0" ){
                            alert("Registration Year cannot be blank");
                            form.last_reg_year_id.focus();
                        } /*
                        else if(form.member_reg_no.value == "" ){
                            alert("Member Registration No can't be blank");
                            form.member_reg_no.focus();
                        }   */
                        else if(form.reg_date.value == "0000-00-00" || form.reg_date.value ==""  || checkdate(form.reg_date)==false){
                            alert("Enter valid Registration date");
                            form.reg_date.focus();
                        }
                        else if(!(reg.getTime()>=start.getTime() && reg.getTime()<=end.getTime())){
                            alert("Registration date must be between "+form.start_date.value+" and "+form.end_date.value);
                            form.reg_date.focus();
                        }
                        else if(form.money_receipt_no.value == "" ){
                            alert("Money Receipt No. cannot be blank");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value ==""  || checkdate(form.money_receipt_date)==false){
                            alert("Enter Money Receipt date");
                            form.money_receipt_date.focus();
                        }/*
                        else if (form.is_memorandum_article[1].checked == false){
                                     alert("Memorandum and Article of Association essential");
                                     form.is_memorandum_article[1].focus();
                        }
                        else if (form.is_registration_certificate[1].checked == false){
                                     alert("Registration Certificate is essential");
                                     form.is_memorandum_article[1].focus();
                        }*/
                        else if(form.firm_name.value == ""){
                            alert("The firm's name cannot be blank");
                            form.firm_name.focus();
                        }
                        else if(form.firm_reg_address_street.value == ""){
                            alert("Enter street address of the firm");
                            form.firm_reg_address_street.focus();
                        }
                           else if (form.firm_email.value != "" && echeck(form.firm_email.value)==false){
                              form.firm_email.focus();
                           }
                       /* else if(form.firm_reg_address_town_suburb.value == ""){
                            alert("Enter Firm Town/ Suburb Address");
                            form.firm_reg_address_town_suburb.focus();
                        }
                        else if((form.firm_email.value!="") && (form.firm_email.value.indexOf('@', 0) == -1 || form.firm_email.value.indexOf('.', 0) == -1)){
                            alert("Enter Valid E-mail Address");
                            form.firm_email.focus();
                        }*/
                        else if(form.location.value == "0" ){
                            alert("Select a Location");
                            form.location.focus();
                        }
                        else if(trim(form.representative_name.value)==""){
                            alert("You must enter the representative's name");
                            form.representative_name.focus();
                        }  /*
                        else if(trim(form.employee_total.value)==""){
                            alert("You must enter Total No of  Employee");
                            form.representative_name.focus();
                        }
                        else if(trim(form.proposer_1_firm_name.value)==""){
                            alert("You must enter the proposer's firm's Name");
                            form.proposer_1_firm_name.focus();
                        }
                        else if(trim(form.proposer_2_firm_name.value)==""){
                            alert("You must enter the socendor's firm's Name");
                            form.proposer_2_firm_name.focus();
                        }*/
                         else if (form.firm_email.value != "" && echeck(form.firm_email.value)==false){
                              form.firm_email.focus();
                        }
                        else {
                                submitform( pressbutton );
                        }
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Group and Town Association:
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
                                        Group and Town Association Information  <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>
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
                                        Last Membership No :
                                        </td>
                                        <td >
                                       <?php echo "&nbsp;Town Associate - ".intval($max_reg_no[0]).", Group - ".intval($max_reg_no[1]); ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Membership No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $row->member_reg_no; ?>" size="30" maxlength="10" onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid Membership Number');" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Date :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->reg_date); ?>" size="20"   onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd-mm-yyyy'); ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                          <td  align="right">
                                              * Money Receipt No :
                                              </td>
                                              <td >
                                              <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $row->money_receipt_no; ?>" size="30" maxlength="15"  />
					      &nbsp;<a href="javascript:newwindow_money_receipt();" style="text-decoration:underline;">Check Money Receipt Number</a>
                                              </td>
                                        </tr>
                                              <tr width=100%>
                                                <td  align="right">
                                                <div align=right>* Money Receipt Date :</div>
                                                </td>
                                                <td >
                                                <input  class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->money_receipt_date); ?>" size="20"    onBlur="checkdate(this)"  />
                                                <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
                                                <?php echo mosToolTip('Date Format : dd-mm-yyyy'); ?>
                                                </td>
                                           </tr>
                                <tr width=100%>
                                        <td width="30%" align="right">
                                        Is Memorandum and Article of Association :
                                        </td>
                                        <td width="70%">
                                        <?php echo $lists['is_memorandum_article']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width="30%" align="right">
                                        Is Registration of Certificate :
                                        </td>
                                        <td width="70%">
                                        <?php echo $lists['is_registration_certificate']; ?>
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
                                           <tr width=100%>
                                                    <td height="26" align="center" colspan="2" valign="bottom">
                                                     <!--b>Applicant Firm Information</b-->
                                                     <b>Registered Information</b>
                                                    </td>
                                                </tr>
                                           <tr width=100%>
                                                     <td  align="right" >
                                                     * Name of the Group / Town :
                                                     </td>
                                                     <td >
                                                     <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm_name; ?>" size="54" maxlength="100"  />
                                                     </td>
                                             </tr>
                                             <tr width=100%>
                                                   <td  align="right" >
                                                   * Street /Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="firm_reg_address_street" value="<?php echo $row->firm_reg_address_street; ?>" size="54" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                    Thana / Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_town_suburb" value="<?php echo $row->firm_reg_address_town_suburb; ?>" size="20" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   <input class="text_area" type="text" name="firm_reg_address_district" value="<?php echo $row->firm_reg_address_district; ?>" size="21" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_division" value="<?php echo $row->firm_reg_address_division; ?>" size="20" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   <input class="text_area" type="text" name="firm_reg_address_country" value="<?php echo $row->firm_reg_address_country; ?>" size="21" maxlength="30"  />
                                                   </td>
                                           </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Phone :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $row->firm_phone; ?>" size="20" maxlength="50"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                                    <input class="text_area" type="text" name="firm_fax" value="<?php echo $row->firm_fax; ?>" size="21" maxlength="125"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Mobile :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_mobile" value="<?php echo $row->firm_mobile; ?>" size="54" maxlength="30"  />
                                                    </td>
                                            </tr>

                                            <tr width=100%>
                                                    <td  align="right">
                                                    Email address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_email" value="<?php echo $row->firm_email; ?>" size="54" maxlength="125"  />
                                                    </td>
                                            </tr><tr width=100%>
                                                    <td  align="right">
                                                    Web address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_web" value="<?php echo $row->firm_web; ?>" size="54" maxlength="125"  />
                                                    </td>
                                            </tr>

                                            <tr width=100%>
                                                <td  align="right">
                                                <div align=right> Date of Formation :</div>
                                                </td>
                                                <td >
                                                <input class="text_area" type="text" name="date_of_formation" id="date_of_formation" value="<?php echo mosHTML::ConvertDateDisplayShort($row->date_of_formation); ?>" size="20"   onBlur="checkdate(this)"   />
                                                <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                                <?php echo mosToolTip('Date Format : dd-mm-yyyy'); ?>
                                                </td>
                                            </tr>
                                            <tr width=100%>
                                                <td  align="right">
                                                Paid In :
                                                </td>
                                                <td >
                                                <?php echo $lists['payment_mode']; ?>
                                                </td>
                                              </tr>
                                              <tr width=100%>
                                                      <td  align="right">
                                                      Total No. of Member :
                                                      </td>
                                                      <td >
                                                      <input class="text_area" type="text" name="employee_total" value="<?php echo $row->employee_total; ?>" size="50" maxlength="30" onKeyUp="javascript:check_IntNumber('employee_total','Enter Valid No');" />
                                                      </td>
                                              </tr>

                                              <tr width=100%>
                                                  <td  align="right">
                                                    * Location :
                                                   </td>
                                                    <td >
                                                         <?php echo $lists['location']; ?>
                                                   </td>
                                              </tr>
                                              <tr width=100%>
                                                      <td  align="right">
                                                      * Name of the Representative :
                                                      </td>
                                                      <td >
                                                      <?php echo $lists['representative_title'];?>
                                                       &nbsp;&nbsp;First Name

                                                      <input class="text_area" type="text" name="representative_name" value="<?php echo $row->representative_name; ?>" size="20" maxlength="25"  />
                                                      &nbsp;&nbsp;Last Name
                                                      <input class="text_area" type="text" name="representative_last_name" value="<?php echo $row->representative_last_name; ?>" size="20" maxlength="25"  />
                                                      </td>
                                              </tr>
                                              <tr width=100%>
                                                      <td  align="right">
                                                      Designation :
                                                      </td>
                                                      <td >
                                                      <?php echo $lists['representative_designation']; ?>
                                                      </td>
                                              </tr>
                                              <tr width=100%>
                                              <td  height=24 align="center" colspan=2 valign=bottom>
                                               <b>Proposer Information</b>
                                               </td>
                                               </tr>

                                              <tr width=100%>
                                                             <td width=30% align="right">
                                                             Name of the Firm :
                                                             </td>
                                                             <td width=70%>
                                                             <input class="text_area" type="text" name="proposer_1_firm_name" value="<?php echo $row->proposer_1_firm_name; ?>" size="50" maxlength="255"  />
                                                             </td>
                                                     </tr>

                                              <tr width=100%>
                                                      <td  align="right">
                                                      Name of the Proposer :
                                                      </td>
                                                      <td >
                                                      <?php echo $lists['proposer_1_title']; ?>
                                                       &nbsp;&nbsp; First Name:
                                                      <input class="text_area" type="text" name="proposer_1_name" value="<?php echo $row->proposer_1_name; ?>" size="20" maxlength="25"  />
                                                      &nbsp;&nbsp;&nbsp;Last Name :
                                                      <input class="text_area" type="text" name="proposer_1_last_name" value="<?php echo $row->proposer_1_last_name; ?>" size="20" maxlength="25"  />
                                                      </td>
                                              </tr>
                                              <tr width=100%>
                                                      <td  align="right">
                                                      Designation :
                                                      </td>
                                                      <td >
                                                      <?php echo $lists['proposer_1_designation']; ?>
                                                      </td>
                                              </tr>
                                              <!--tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Proposer' onclick=javascript:newwindow(1); />
                                                        </td>
                                 </tr-->
                                              <tr width=100%>
                                                 <td  height=24 align="center" colspan=2 valign=bottom>
                                                 <b>Seconder Information</b>
                                                 </td>
                                               </tr>
                                               <tr width=100%>
                                        <td width=30% align="right">
                                        Name of the Firm :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_2_firm_name" value="<?php echo $row->proposer_2_firm_name; ?>" size="50" maxlength="100"  />
                                        </td>
                                </tr>

                                              <tr width=100%>
                                                      <td  align="right">
                                                      Name of the Seconder :
                                                      </td>
                                                      <td >
                                                      <?php echo $lists['proposer_2_title']; ?>
                                                      &nbsp;&nbsp; First Name:
                                                      <input class="text_area" type="text" name="proposer_2_name" value="<?php echo $row->proposer_2_name; ?>" size="20" maxlength="25"  />
                                                      &nbsp;&nbsp;&nbsp;Last Name :
                                                      <input class="text_area" type="text" name="proposer_2_last_name" value="<?php echo $row->proposer_2_last_name; ?>" size="20" maxlength="25"  />

                                                      </td>
                                              </tr>
                                              <tr width=100%>
                                                      <td  align="right">
                                                      Designation :
                                                      </td>
                                                      <td >
                                                      <?php echo $lists['proposer_2_designation']; ?>
                                                      </td>
                                              </tr>
                                              <!--tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Seconder' onclick=javascript:newwindow(2); />
                                                        </td>
                                 </tr-->



                </td>
                </tr>
                </table>

                <input type="hidden" name="option" value="com_member_group_town_ccci" />
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
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img4",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                </script>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "date_of_formation",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <?php
        }

}
?>
