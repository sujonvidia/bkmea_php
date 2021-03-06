<?php
/**
* @version $Id: admin.membership_renew_scci.html.php,v 1.23 2006/07/24 04:46:16 morshed Exp $
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
class Member_renew_html {

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
                        <th class="categories">
                               Membership Renewal
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
                        <th width="2" align="left">

                        </th>
                        <th width="10" align="left">
                        #
                        </th>
                        <th class="name" width=20% align="left">
                        Membership Code
                        </th>
                        <th class="title" align=left width=35%>
                        Firm Name
                        </th>
                        <th class="name" width=30% align=left>
                        Applicant Name
                        </th>

                        <th class="name" width=15% align=center>
                        Member Type
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_membership_renew_scci&task=editA&hidemainmenu=1&id='. $row->id;

                        $access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>

                                 </td>
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <td align="left">
                                <?php echo $row->member_reg_no; ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" class="underline">
                                <?php echo stripslashes($row->companyname); ?>
                                </a>
                                </td>
                                <td >
                                <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>
                                </td>

                                <td align="center">
                                <?php echo stripslashes($row->member_type);?>
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

                <input type="hidden" name="option" value="com_membership_renew_scci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="chosen" value="" />
                <input type="hidden" name="act" value="" />
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


        function edit( &$cur_reg_year, &$renew, &$row, &$lists, $redirect, $start_date, $end_date ) {
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format;
                global $my;
                         //administrator
                if(strtolower(trim($my->usertype))=="super administrator")
                   $readonly="";
                else
                   $readonly="readonly";

                $_SESSION['row']=$row;
                $_SESSION['cur_reg_year']=$cur_reg_year;
                $_SESSION['renew']=$renew;





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


                 function check_cn1()
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.adminForm;

                   str=form.RenewFee.value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 38; j++)
                      {
                        if(str.charAt(i) == arr[j]){
                          if ((str.charAt(i)==".")&& (che==0))
                          {
                                  che=1;
                          }
                          else if ((str.charAt(i)==".")&& (che==1))
                          {
                              alert("Enter valid Renewal fee");
                              form.RenewFee.focus();
                              //form.RenewFee.value="";
                          }
                           break;
                        }

                      }
                      if(j>37)
                      {
                        alert("Enter valid Renewal fee");
                        form.RenewFee.focus();
                        //form.RenewFee.value="";
                        break;
                      }
                   }
                }



                function check_cn2()
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.adminForm;

                   str=form.RenewFee.value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 38; j++)
                      {
                        if(str.charAt(i) == arr[j]){
                          if ((str.charAt(i)==".")&& (che==0))
                          {
                                  che=1;
                          }
                          else if ((str.charAt(i)==".")&& (che==1))
                          {
                              return false;
                              //form.RenewFee.value="";
                          }
                           break;
                        }

                      }
                      if(j>37)
                      {
                        return false;
                        //form.RenewFee.value="";
                        break;
                      }
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
                var strSeparatorArray = "-";
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
                /*
                if(strYear){
                      if (strYear.length == 2 ) {
                          strYear = '20' + strYear;
                      }
                }
                */
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

                 var newWin;
                function newwindow_money_receipt(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                      page='../popup/moneyReceipt_popup.php?money_receipt_no='+document.adminForm.money_receipt_no.value+'&formName=adminForm';
                      newWin=window.open(page,'','width=425,height=130,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      newWin.focus();
               }
//  End -->
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var start, end, reg;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        ren   =trim(form.renew_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        ren=new Date(ren.split('-')[2],ren.split('-')[1],ren.split('-')[0]);


                        var issue, expire;
                        issue =trim(form.trade_licence_issue_date.value);
                        expire =trim(form.trade_licence_expire_date.value);
                        issue=new Date(issue.split('-')[2],issue.split('-')[1],issue.split('-')[0]);
                        expire=new Date(expire.split('-')[2],expire.split('-')[1],expire.split('-')[0]);

                        var type_id='<?php echo $row->member_type_id; ?>';

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(form.firm_name.value == "" ){
                            alert("Please enter name of the firm");
                            form.firm_name.focus();
                        }
                        else if(form.member_reg_no.value == "" ){
                            alert("Membership Code can not be blank or ");
                            form.member_reg_no.focus();
                        }
                        else if(form.member_reg_no.value == 0){
                            alert("Membership Code can not be 0 ");
                            form.member_reg_no.focus();
                        }
                        else if(form.money_receipt_no.value == ""){
                            alert("You must enter money receipt No.");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == "" || checkdate(form.money_receipt_date)==false){
                            alert("You must enter money receipt date");
                            form.money_receipt_date.focus();
                        }
                        else if((type_id==3 || type_id==4) && form.trade_licence_issued_by.value == "" ){
                            alert("You must enter trade license issued authority ");
                            form.trade_licence_issued_by.focus();
                        }
                        else if((type_id==3 || type_id==4) && form.trade_licence_no.value == "" ){
                            alert("You must enter trade license No. ");
                            form.trade_licence_no.focus();
                        }
                         else if((type_id==3 || type_id==4) && form.trade_licence_issue_date.value == "" || checkdate(form.trade_licence_expire_date)==false){
                               alert("Trade license issue date cannot be blank");
                               form.trade_licence_issue_date.focus();
                        }
                        else if((type_id==3 || type_id==4) && form.trade_licence_expire_date.value == "" || checkdate(form.trade_licence_expire_date)==false){
                               alert("Trade license expiry date cannot be blank");
                               form.trade_licence_expire_date.focus();
                        }
                        else if((type_id==3 || type_id==4) && issue.getTime()>=expire.getTime()){
                            alert("Trade license date "+form.trade_licence_issue_date.value+" must be less than trade license expire date "+form.trade_licence_expire_date.value);
                            form.trade_licence_issue_date.focus();
                        }
                        else if((type_id==3 || type_id==4) && form.tin.value == "" ){
                            alert("You must enter TIN No.");
                            form.tin.focus();
                        }
                        else if(form.RenewFee.value == ""){
                            alert("You must enter renewal fee ");
                            form.RenewFee.focus();
                        }
                        else if(form.bank.value == "0"){
                            alert("You must select a Bank ");

                        }
                        else if(form.renew_date.value==""  || checkdate(form.renew_date)==false){
                            alert("Please enter renewal date");
                            form.renew_date.focus();
                        }
                        else if(ren.getTime()<start.getTime() || ren.getTime()>end.getTime()){
                            alert("Renewal date must be between "+form.start_date.value+" and "+form.end_date.value);
                            form.renew_date.focus();
                        }
                        else{
                             str=true;
                             str=check_cn2();
                             if (str !=false  )
                             {

                                var con=0;
                                con =confirm("Are you sure ? ");

                                if (con==1)
                                {
                                  submitform( pressbutton );
                                }
                                else
                                   return;
                             }
                             else
                             {
                                  alert("You must enter valid Renewal fee ");
                                  form.RenewFee.focus();
                             }
                        }
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                   <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                <table class="adminheading">

                <tr>
                        <th class="categories">

                         Membership Renewal
                        <!--small>
                        <?php echo $history->historyid ? 'Edit' : 'New';  ?>
                        </small-->


                        </th>
                </tr>

                </table>

                <table width="100%">

                <tr>
                        <td valign="top" width="100%">
                        <center>
                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        Member's  Information <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                <tr>
                                <!--tr>
                                        <td width=30% ALIGN="right">
                                        Name of the Firm :
                                        </td>
                                        <td width=70%  >
                                          <?php echo stripslashes($row->firm); ?>
                                        </td>
                                </tr-->
                                <tr>
                                        <td  width=30% ALIGN="right">

                                       * Name of the Firm :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm; ?>" size="30" maxlength="50"  >

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Applicant Name :
                                        </td>
                                        <td >
                                        <?php
                                        $link = 'index2.php?option=com_membership_edit_scci&task=editA&hidemainmenu=1&id='. $row->id;
                                        ?>
                                        <a href="<?php echo $link; ?>" title="Edit Membership" class="underline" >
                                          <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>
                                         </a>
                                        <!--?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?-->

                                        </td>
                                </tr>

                                <tr>
                                        <td ALIGN="right">
                                        Current Membership Code :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $row->lastRegNO; ?>" size="27" maxlength="10" onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid membership code');" <?php echo $readonly; ?>/>
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php //echo $row->lastRegNO;
                                        ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Renewal For Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $cur_reg_year->curr_reg_year; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        * Bank :
                                        </td>
                                        <td >
                                       <?php echo $lists['bank']; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        * Money Receipt No :
                                        </td>
                                        <td >

                                        <!--input class="text_area" type="text" name="money_receipt_no"  value="<?php echo $history->historyid ? $history->money_receipt_no : ''; ?>"  size="20" maxlength="15"  -->

                                        <input class="text_area" type="text" name="money_receipt_no"  size="20" maxlength="15" onkeyup=javascript:check_cn1(); >
                                       &nbsp;<a href="javascript:newwindow_money_receipt();" style="text-decoration:underline;">Check Money Receipt Number</a>
                                        </td>
                                </tr>
                               <tr>
                                        <td align=right>
                                        * Money Receipt Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="" size="20" maxlength="255"   onBlur="checkdate(this)"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0  class="calender_link">
                                         <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                        </td>
                                </tr>
                                 <tr>
                                        <td  ALIGN="right">
                                        <?php if($row->member_type_id==3 || $row->member_type_id==4 ) echo "*"; ?>
                                        Trade License Issued Authority :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="<?php echo $row->trade_licence_issued_by; ?>" size="30" maxlength="50"  >

                                        </td>
                                </tr>
                                 <tr>
                                        <td  ALIGN="right">
                                        <?php if($row->member_type_id==3 || $row->member_type_id==4 ) echo "*"; ?>
                                        Trade License No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="trade_licence_no"  size="20" maxlength="15"  >

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        <?php if($row->member_type_id==3 || $row->member_type_id==4 ) echo "*"; ?>
                                        Issue Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_issue_date" id="trade_licence_issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->trade_licence_issue_date); ?>" size="20" maxlength="20"  onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
                                         <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <?php if($row->member_type_id==3 || $row->member_type_id==4 ) echo "*"; ?>
                                        Expiry Date :
                                        </td>
                                        <td>
                                        <?php $year_of_expiry=explode('-',$cur_reg_year->curr_reg_year);
                                              $tmp=explode('-',mosHTML::ConvertDateDisplayShort($row->trade_licence_expire_date));
                                              $trade_licence_expire_date=trim($tmp[0])."-".trim($tmp[1])."-".trim($year_of_expiry[1]);
                                        ?>
                                        <input class="text_area" type="text" name="trade_licence_expire_date" id="trade_licence_expire_date" value="<?php echo $trade_licence_expire_date;  ?>" size="20" maxlength="20"  onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img5" border=0 class="calender_link">
                                        <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        <?php if($row->member_type_id==3 || $row->member_type_id==4 ) echo "*"; ?>
                                        TIN Number :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="tin" value="<?php echo $row->tin; ?>" size="20" maxlength="20"  >

                                        </td>
                                </tr>
                                 <tr>
                                        <td ALIGN="right">
                                        * Renewal Fee :
                                        </td>
                                        <td >
                                        <input class="text_area"  type="text" name="RenewFee" onkeyup=javascript:check_cn1(); value="<?php echo ($renew->renewal_fee+$renew->certificate_fee) ; ?>" readonly=true size="20" maxlength="255"  >
                                        <?php echo mosToolTip('This is the Renewal fee of this year'); ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        * Renewal Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="renew_date" id="renew_date" value="" size="20" maxlength="255"   onBlur="checkdate(this)"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0  class="calender_link">
                                         <?php //echo mosToolTip('Date Format : dd-mm-yyyy');
                                        ?> <b> dd-mm-yyyy  </b>
                                        </td>
                                 </tr>
                                 <!--tr>
                                        <td align=right>
                                        * Is voter :
                                        </td>
                                        <td colspan="2">
                                        <?php echo $lists['is_voter'];
                                        ?>
                                        </td>
                                 </tr-->
                                 <tr>
                                        <td width=15% ALIGN="right" height=50>

                                        </td>
                                        <td >
                                        </td>
                                </tr>
                                </table>
                                </center>
                        </td>
                </tr>

                </table>

                <input type="hidden" name="option" value="com_membership_renew_scci" />
                <input type="hidden" name="certificate_fee" value="<?php echo $renew->certificate_fee; ?>" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>

                <script language="javascript" type="text/javascript">
                        Calendar.setup({
                        inputField     :    "renew_date",      // id of the input field
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
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <script language="javascript" type="text/javascript">
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

        function previewMember_renew( &$lists, $redirect, $menus ) {
                global $mosConfig_absolute_path;

                $cur_reg_year1=$_SESSION['cur_reg_year'];
                $renew1=$_SESSION['renew'];
                $row1=$_SESSION['row'];

                $money_receipt_no= $_POST['money_receipt_no'];
                $RenewFee1= $_POST['RenewFee'];
                $is_voter=$_POST['is_voter'];
                $history=$_SESSION['history'];

                $_SESSION['is_voter']=$is_voter;
                $_SESSION['money_receipt_no']=$money_receipt_no;
                $_SESSION['RenewFee']=$RenewFee1;

                //session_unregister();



                ?>
                <script language="javascript" type="text/javascript">
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        var con=0;
                         con =confirm("Are you sure");

                         if (con==1)
                         {
                                  submitform( pressbutton );
                         }

                        // else return false;
                        //RenewFee

                      /*  if(form.title.value == ""){
                            alert("Please enter category title");
                            form.title.focus();
                        }else if(form.name.value == ""){
                            alert("You must enter category name");
                            form.name.focus();
                        }else {
                                submitform( pressbutton );
                        }*/// newly changed

                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Membership Renew
                        <small>
                        <!--?php echo $row1->id ? 'Edit' : 'New';  ?-->
                        <?php Echo 'View' ?>
                        </small>
                        </th>
                </tr>
                </table>

                <center>
                <table width="100%">

                <tr>
                        <td valign="top" width="60%">

                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        Membership Renew details Information
                                        </th>
                                <tr>
                                <tr>
                                        <td width=15% >
                                        Name of the firm
                                        </td>
                                        <td width=45%>
                                          <?php echo $row1->firm; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td>
                                        Applicant Name :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row1->aplicant; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td>
                                        Current membership no :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row1->lastRegNO; ?>

                                        </td>
                                </tr>


                                 <tr>
                                        <td>
                                        Last renewal year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row1->yeartitle; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td>
                                        Renewal for year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $cur_reg_year1->curr_reg_year; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td>
                                        Money receipt no :
                                        </td>
                                        <td >
                                        <?php echo $money_receipt_no; ?>

                                        </td>
                                </tr>

                                 <tr>
                                        <td>
                                        Renewal fee :
                                        </td>
                                        <td >
                                        <?php echo $RenewFee1; ?>

                                        </td>
                                </tr>



                                  <!--tr>
                                        <td>
                                        Voter :
                                        </td>
                                        <td>
                                       <?php echo  $is_voter==1 ? 'Voter' : 'Not Voter' ; ?>
                                        </td>


                                </tr-->





                                </table>

                        </td>
                </tr>

                </table>

                </center>


                <input type="hidden" name="option" value="com_membership_renew_scci" />
                <!--input type="hidden" name="id" value="<?php echo $row->id; ?>" /-->
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

}
?>
