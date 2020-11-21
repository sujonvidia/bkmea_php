<?php
/**
* @version $Id: admin.membership_bkmea.html.php,v 1.32 2006/08/13 11:11:41 morshed Exp $
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
                        <th class="type" align="left" with=20%>
                        Membership No.
                        </th>
                        <th class="firmname" width=25% align="left">
                        Firm Name
                        </th>
                        <th class="name" align="left" width=25%>
                        Applicant Name
                        </th>

                        <th class="type" align="left" with=15%>
                        Member Type
                        </th>
                         <th class="name" align="center" width=15%>
                        Member Category
                        </th>
                        <!--th width="5%">
                        Published
                        </th>
                        <th width="5%">
                        Approved
                        </th>
                        <th colspan="2" width="5%">
                        Reorder
                        </th>
                        <th width="5%">
                        Hits
                        </th-->
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];

                        $link         = 'index2.php?option=com_membership_edit_bkmea&task=editA&hidemainmenu=1&id='. $row->id;

                        //$task         = $row->published ? 'unpublish' : 'publish';
                        //$img         = $row->published ? 'publish_g.png' : 'publish_x.png';
                        //$alt         = $row->published ? 'Published' : 'Unpublished';

                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );

                        //$row->cat_link         = 'index2.php?option=com_membership&task=editA&hidemainmenu=1&id='. $row->id;
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <td>
                                <?php echo $checked; ?>
                                </td>
                                <td align="left">
                                <?php echo stripslashes($row->member_reg_no); ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" title="Edit Membership" class="underline">
                                <?php echo stripslashes($row->firm_name); ?>
                                </a>
                                </td>
                                <td>
                                <?php echo stripslashes($row->applicant_title)." ".stripslashes($row->applicant_name)." ".stripslashes($row->applicant_last_name); ?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->type); ?>
                                </td>
                                <td align="center">
                                <?php echo stripslashes($row->category); ?>
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
        function editMembership( &$rows, &$lists, $option, $id, $start_date, $end_date ) {
                global $mosConfig_live_site, $mosconfig_calender_date_format;
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
                   switch(mid){

                           case  2:
                              msg="Enter valid Male Number";
                              break;
                           case  3:
                              msg="Enter valid Female Number";
                              break;

                   }

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
                   if(mid==2 || mid==3){
                     var temp  = parseInt(form.employee_male.value);
                     var temp1 = parseInt(form.employee_female.value);
                     if(isNaN(temp))
                          temp=0;
                     if(isNaN(temp1))
                          temp1=0;
                     form.employee_total.value=temp+temp1;
                   }
                }
                function check_FloatNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.adminForm;
                   var msg1="Enter valid Amount";
                   var msg2="";
                   var msg="";
                  if(mid==1)
                     msg=msg1;
                   else
                     msg=msg2;
                   str=form.elements[obj].value;

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
                              alert(msg);
                              form.elements[obj].focus();
                              form.elements[obj].select();

                          }
                           break;
                        }

                      }
                      if(j>37)
                      {

                        alert(msg);
                        var temp = parseFloat(str);
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


                function copy_firm_address(){
                         var form = document.adminForm;
                        if (form.check_firm_address.checked==true){
                                form.office_address_street.value="";
                                form.office_address_town_suburb.value="";
                                form.office_address_district.value="";
                                form.office_address_division.value="";
                                form.office_address_country.value="";
                                //form.office_phone.value="";
                                form.office_fax.value="";
                                form.office_mobile.value="";
                                form.office_email.value="";
                                form.office_web.value="";

                                form.office_address_street.value=form.applicant_address_street.value;
                                form.office_address_town_suburb.value=form.applicant_address_town_suburb.value;
                                form.office_address_district.value=form.applicant_address_district.value;
                                form.office_address_division.value=form.applicant_address_division.value;
                                form.office_address_country.value=form.applicant_address_country.value;
                                //form.office_phone.value=form.applicant_office_phone.value;
                                form.office_fax.value=form.applicant_fax.value;
                                form.office_mobile.value=form.applicant_mobile.value;
                                form.office_email.value=form.applicant_email.value;
                                form.office_web.value=form.applicant_web.value;
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


                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                        var start, end, reg,i;
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


                        else {


                        var bln_error=false;
                        if(form.type_id.value == "0"){
                            alert("You must select a member type ");
                            bln_error=true;
                            form.type_id.focus();
                        }/*
                        else if(form.member_category_id.value == "0" ){
                             bln_error=true;
                            alert("Select Member Category");
                            form.member_category_id.focus();
                        }   */
                        else if(form.last_reg_year_id.value == "0" ){
                             bln_error=true;
                            alert("Registration year cannot be blank");
                            form.last_reg_year_id.focus();
                        }
                        else if(form.member_reg_no.value == "" ){
                             bln_error=true;
                            alert("Membership No. cannot be blank");
                            form.member_reg_no.focus();
                        }
                        else if(form.reg_date.value == "0000-00-00" || form.reg_date.value ==""){
                             bln_error=true;
                            alert("Enter valid registration date");
                            form.reg_date.focus();
                        }
                        else if(reg.getTime()<start.getTime() || reg.getTime()>end.getTime()){
                             bln_error=true;
                            alert("Registration date must be between "+form.start_date.value+" and "+form.end_date.value);
                            form.reg_date.focus();
                        }
                        else if(form.money_receipt_no.value == "" ){
                             bln_error=true;
                            alert("Money receipt No. cannot be blank");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value ==""){
                             bln_error=true;
                            alert("Enter valid money receipt date");
                            form.money_receipt_date.focus();
                        }
                        else if(form.firm_name.value == ""){
                             bln_error=true;
                            alert("Name of the firm cannot be blank");
                            form.firm_name.focus();
                        }
                        else if(form.applicant_name.value == ""){
                        bln_error=true;
                               alert("Name of applicant cannot be blank");
                               form.applicant_name.focus();
                           }

                         /*  else if(form.representative_name.value == ""){
                                   bln_error=true;
                               alert("You must enter Representative Name");
                               form.representative_name.focus();
                           }
                           else if(form.representative_designation.value == "0"){
                                   bln_error=true;
                               alert("You must enter Representative Designation");
                               form.representative_designation.focus();
                           } */
                        else if(form.applicant_address_street.value == ""){
                                bln_error=true;
                            alert("Enter street/ area of factory address");
                            form.applicant_address_street.focus();
                        }
                       /*
                        else if(form.trade_licence_no.value == ""){
                        bln_error=true;
                               alert("Trade License No. can't be blank");
                               form.trade_licence_no.focus();
                        }
                         else if(form.trade_licence_issued_by.value == ""){
                         bln_error=true;
                               alert("Authority of Trade License can't be blank");
                               form.trade_licence_issued_by.focus();
                        }
                         else if(form.trade_licence_issue_date.value == ""){
                                 bln_error=true;
                               alert("Trade License issue date can't be blank");
                               form.trade_licence_issue_date.focus();
                        }
                        else if(form.trade_licence_expire_date.value == ""){
                                bln_error=true;
                               alert("Trade License expire date can't be blank");
                               form.trade_licence_expire_date.focus();
                        }

                        else if(form.tin.value == ""){
                        bln_error=true;
                               alert("Tax payers Identification No. can't be blank");
                               form.tin.focus();
                        }
                        else if(form.proposer_one_name.value == ""){
                        bln_error=true;
                            alert("Proposer Name can't be blank");
                            form.proposer_one_name.focus();
                        }

                        else if(form.proposer_one_member_reg_no.value == ""){
                                bln_error=true;
                            alert("Proposer registration code can't be blank");
                            form.proposer_one_member_reg_no.focus();
                        }
                        else if(form.proposer_two_name.value == ""){
                        bln_error=true;
                            alert("Seconder Name can't be blank");
                            form.proposer_two_name.focus();
                        }

                        else if(form.proposer_two_member_reg_no.value == ""){
                        bln_error=true;
                            alert("Seconder registration code can't be blank");
                            form.proposer_two_member_reg_no.focus();
                        }*/
                        else if(form.applicant_email.value != "" && echeck(form.applicant_email.value)==false){
                              bln_error=true;
                              form.applicant_email.focus();
                        }
                        else if(form.elements['location'].value ==0){
                                bln_error=true;
                            alert("Please select a location");
                            form.location.focus();
                        }
                        else if(form.office_email.value != "" && echeck(form.office_email.value)==false){
                              bln_error=true;
                              form.office_email.focus();
                        }
                        else{
                         for (i=0;i<form.elements['enclosure[]'].length;i++){
                                if (form.elements['enclosure[]'][i].value==form.elements['check_enclosure[]'][i].value){
                                        if (form.elements['enclosure[]'][i].checked==false){
                                                 bln_error=true;
                                                 alert(form.elements['message[]'][i].value);
                                                 form.elements['enclosure[]'][i].focus();
                                                 return;
                                        }
                                }
                        }
                         }
                         if (bln_error==false){
                                submitform( pressbutton );
                        }
                     }
                }
                  var newWin;

                function newwindow(from)
               {
                         if (null != newWin && !newWin.closed)

                         closeNewWindow();
                         page='../proposer_info.php?from='+from+'&formid=0';
                         newWin=window.open(page,'','width=399,height=90,scrollbars=no,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                         var form = document.adminForm;
                         //location.href=popup.php;
                         //newWin.document.forms[chkform].name.value="a";
                         //opener.document.forms[chkform].name.value=form.username.value;

                         newWin.focus();

               }

                </script>
                <form action="index2.php" method="post" name="adminForm" id="adminForm">
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
                                  <tr><td width="40%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->

                               <tr width=100%>
                                        <td  width="31%" align="right">
                                        * Member Type :
                                        </td>
                                        <td width="69%">
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td  align="right">
                                        Member Category :
                                        </td>
                                        <td >
                                        <?php echo $lists['member_category_id'];?>
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
                                        * Membership No. :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $row->member_reg_no; ?>" size="27" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Date :</div>
                                        </td>
                                        <td >
                                        <input readonly class="text_area" type="text" name="reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->reg_date); ?>" size="20"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>


                                 <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td width="60%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->

                                 <tr width=100%>
                                        <td  align="right" width="40%">
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $row->money_receipt_no; ?>" size="27" maxlength="15"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Money Receipt Date :
                                        </td>
                                        <td >
                                        <input readonly class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->money_receipt_date); ?>" size="20"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td align="right">
                                        Date of Commencing :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="commencing_date" id="commencing_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->commencing_date); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img3" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        Member Status :
                                        </td>
                                        <td >
                                        <?php echo $lists['member_status'];?>
                                        </td>
                                </tr>
                               <tr width=100%>
                                        <td  align="right">
                                        Direct Export :
                                        </td>
                                        <td >
                                        <?php echo $lists['is_direct_export'];?>
                                        </td>
                                </tr>

                                 <tr width=100%>
                                        <td  align="right">
                                        Initial Investment :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="investment" size="21" maxlength="15"  onKeyUp="javascript:check_FloatNumber('investment',1);" />
                                        &nbsp;Million Tk.</td>
                                </tr>



                                <!--tr width=100%>
                                        <td  align="right" >
                                         * Corporate Status :
                                        </td>
                                        <td >
                                        <?php echo $lists['corporate_status'];
                                        ?>
                                        </td>
                                </tr-->
                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>
                                <!-- modified by mizan end-->

                                <!--tr width=100%>
                                                       <td height=26 align="center" colspan=2 valign=bottom>
                                                       <b>Applicant Information</b>
                                                       </td>
                                    </tr-->
                                <tr width=100% height="5">
                                                       <td height=26 align="center" colspan=2 valign=bottom>
                                                       <b></b>
                                                       </td>
                                 </tr>
                                <tr width=100%>
                                                    <td  align="right" width="25%">
                                                    * Name of the Firm :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm_name; ?>" size="54" maxlength="150"  />

                                                    </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        [ Name of the Applicant ]&nbsp;Title :
                                        </td>
                                        <td >

                                        <?php echo $lists['applicant_title']; ?>
                                        &nbsp;* First Name :&nbsp;
                                        <input class="text_area" type="text" name="applicant_name" value="<?php echo $row->applicant_name; ?>" size="20" maxlength="25"  />
                                        &nbsp;Last Name :&nbsp;
                                         <input class="text_area" type="text" name="applicant_last_name" value="<?php echo $row->applicant_last_name; ?>" size="20" maxlength="25"  />

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        * Designation of the Applicant:
                                        </td>
                                        <td >


                                         <?php echo $lists['applicant_designation']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        [ Phone ]&nbsp;Res. :
                                        </td>
                                        <td >

                                        <input class="text_area" type="text" name="applicant_home_phone" value="<?php echo $row->applicant_home_phone; ?>" size="20" maxlength="50"  />
                                        &nbsp;Office :&nbsp;
                                        <input class="text_area" type="text" name="applicant_office_phone" value="<?php echo $row->applicant_office_phone; ?>" size="20" maxlength="50"  />
                                        &nbsp;Factory :&nbsp;
                                         <input class="text_area" type="text" name="office_phone" value="<?php echo $row->office_phone; ?>" size="20" maxlength="50"  />
                                         &nbsp;(<b>Ex. 88-02-1042215</b>)
                                        </td>
                                </tr>

                                 <!--tr width=100%>
                                        <td height="40" align="center" colspan="2" valign="middle">
                                        <b>Representative Information</b>
                                        </td>
                                </tr-->

                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        [ Name of the Representative ] Title :
                                        </td>
                                        <td >

                                        <?php echo $lists['representative_title']; ?>
                                        &nbsp;First Name :&nbsp;
                                        <input class="text_area" type="text" name="representative_name" value="<?php echo $row->representative_name; ?>" size="20" maxlength="25"  />
                                        &nbsp;Last Name :&nbsp;
                                         <input class="text_area" type="text" name="representative_last_name" value="<?php echo $row->representative_last_name; ?>" size="20" maxlength="25"  />

                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td  align="right" width="25%">
                                        Designation of the Representative:
                                        </td>
                                        <td >


                                         <?php echo $lists['representative_designation']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                         Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="representative_mobile" size="21" maxlength="25"  />

                                        </td>
                                </tr>

                                <!-- Modified by mizan start-->

                                <tr width=100% >
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                  <td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <!-- modified by mizan end-->


                                            <!--tr width=100%>
                                                    <td  align="right" width="25%">
                                                    * Firm Name :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm_name; ?>" size="54" maxlength="150"  />
                                                    </td>
                                            </tr-->
                                            <!--tr width=100%>
                                                    <td  align="right" width="25%">
                                                    * Title :
                                                    </td>
                                                    <td >

                                                    <?php echo $lists['applicant_title'];?>
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right" width="25%">
                                                    * First Name :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_name" value="<?php echo $row->applicant_name; ?>" size="54" maxlength="25"  />

                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right" width="25%">
                                                    * Last Name :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_last_name" value="<?php echo $row->applicant_last_name; ?>" size="54" maxlength="25"  />

                                                    </td>
                                            </tr-->
                                            <!--tr width=100%>
                                                    <td  align="right" width="25%">
                                                    * Firm Name :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_name" value="<?php echo $row->firm_name; ?>" size="54" maxlength="150"  />

                                                    </td>
                                            </tr-->

                                <tr width=100%>
                                                       <td height=26 align="center" colspan=2 valign="middle">
                                                       <b>Factory Address</b>
                                                       </td>
                                    </tr>
                                           <tr width=100%>
                                                   <td  align="right" width="25%">
                                                   * Street/ Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="applicant_address_street" value="<?php echo $row->applicant_address_street; ?>" size="54 maxlength="100"  />

                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana/ Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="applicant_address_town_suburb" value="<?php echo $row->applicant_address_town_suburb; ?>" size="20" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   &nbsp;<input class="text_area" type="text" name="applicant_address_district" value="<?php echo $row->applicant_address_district; ?>" size="20" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="applicant_address_division" value="<?php echo $row->applicant_address_division; ?>" size="20" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   &nbsp;<input class="text_area" type="text" name="applicant_address_country" value="<?php echo $row->applicant_address_country; ?>" size="20" maxlength="30"  />
                                                   </td>
                                           </tr>

                                        <!--tr width=100%>
                                                    <td  align="right" width="25%">
                                                    Phone (Home) :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $row->firm_phone; ?>" size="54" maxlength="30"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Phone (Office) :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $row->firm_phone; ?>" size="54" maxlength="30"  />
                                                    </td>
                                            </tr-->
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Mobile :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_mobile" value="<?php echo $row->applicant_mobile; ?>" size="54" maxlength="30"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Fax :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_fax" value="<?php echo $row->applicant_fax; ?>" size="54" maxlength="50"  />
                                                    </td>
                                            </tr>

                                            <tr width=100%>
                                                    <td  align="right">
                                                    Email Address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_email" value="<?php echo $row->applicant_email; ?>" size="54" maxlength="125"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Web Address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_web" value="<?php echo $row->applicant_web; ?>" size="54" maxlength="125"  />
                                                    </td>
                                            </tr>
                                            <!--tr width=100%>
                                                    <td  align="right">
                                                    Phone :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $row->firm_phone; ?>" size="20" maxlength="30"  />
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                                   &nbsp;<input class="text_area" type="text" name="firm_fax" value="<?php echo $row->firm_fax; ?>" size="20" maxlength="30"  />
                                                    </td>
                                            </tr-->

                                            <tr width=100%>
                                        <td  align="right">
                                         * Location :
                                        </td>
                                        <td >
                                        <?php echo $lists['location']; ?>
                                        </td>
                                </tr>

                                            <!-- modified by mizan start-->

                                            </table>
                                            </td>
                                            <td width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <!-- modified by mizan end-->
                                          <tr width=100% height="40">
                                          <td height=26 align="center" colspan=2 valign="middle">
                                          <b>Office Address</b>&nbsp;
                                          <input class="text_area" type="checkbox" name="check_firm_address" onClick="javascript:copy_firm_address();" />
                                           &nbsp; Copy of Factory Address
                                          </td>
                                          </tr>
                                        <tr width=100%>
                                                   <td  align="right" width="25%">
                                                   Street/ Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="office_address_street" value="<?php echo $row->office_address_street; ?>" size="54" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana/ Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="office_address_town_suburb" value="<?php echo $row->office_address_town_suburb; ?>" size="20" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   &nbsp;<input class="text_area" type="text" name="office_address_district" value="<?php echo $row->office_address_district; ?>" size="20" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="office_address_division" value="<?php echo $row->office_address_division; ?>" size="20" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   &nbsp;<input class="text_area" type="text" name="office_address_country" value="<?php echo $row->office_address_country; ?>" size="20" maxlength="30"  />
                                                   </td>
                                           </tr>
                                <!--tr width=100%>
                                        <td  align="right">
                                        Phone :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_phone" value="<?php echo $row->office_phone; ?>" size="54" maxlength="50"  />
                                        </td>
                                </tr-->
                                 <tr width=100%>
                                        <td  align="right">
                                        Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_mobile" value="<?php echo $row->office_mobile; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Fax :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_fax" value="<?php echo $row->office_fax; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>



                                <tr width=100%>
                                        <td  align="right">
                                        Email address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_email" value="<?php echo $row->office_email; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Web address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_web" value="<?php echo $row->office_web; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>

                                <!-- modified by mizan start-->
                                 </table>

                                 </td>
                                 </tr>
                                 </table>
                                </td>
                                </tr>
                                <tr width=100% >
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr width="100%" height="40">
                                        <td align="center" colspan=2 valign="middle">
                                        <b>Information of License</b>
                                        </td>
                                </tr>
                                  <tr>
                                  <td width="50%">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                 <tr width=100%>
                                        <td  align="right" width="25%">
                                        Trade License Number :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_no" value="<?php echo $row->trade_licence_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                  </tr>
                                  <tr width=100%>
                                        <td align="right">
                                        Issued Authority :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="<?php echo $row->trade_licence_issued_by; ?>" size="54" maxlength="50"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        Issue Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_issue_date" id="trade_licence_issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->trade_licence_issue_date); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Expiry Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="trade_licence_expire_date" id="trade_licence_expire_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->trade_licence_expire_date); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img5" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                 <tr width=100%>
                                <td  align="right">
                                        TIN No. :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="tin" value="<?php echo $row->tin; ?>" size="54" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Bond License No :
                                        </td>
                                        <td >
                                        <input type="text" name="bond_licence_no" class="inputbox" size="50" maxlength="20" value="" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Bond License Date :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bond_licence_issue_date" id="bond_licence_issue_date" value="" size="25" readonly  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img8" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                            </table>
                                            </td>
                                            <td valign="top" width="50%">
                                           <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr width=100%>
                                        <td  align="right" width="25%">
                                        Import Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="import_reg_no" value="<?php echo $row->import_reg_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td align="right">
                                        Expiry Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="import_reg_no_expire_date" id="import_reg_no_expire_date"  size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img6" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                         <td  align="right">
                                        Export Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="export_reg_no" value="<?php echo $row->export_reg_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td align="right">
                                        Expiry Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="export_reg_no_expire_date" id="export_reg_no_expire_date"  size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img7" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                 <!--tr width="100%">
                                        <td  align="right">
                                        Indenting Trade No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="indenting_trade_no" value="<?php echo $row->indenting_trade_no; ?>" size="54" maxlength="20"  />
                                        </td>
                                 </tr-->
                                 <tr width=100%>
                                        <td  align="right" width="25%">
                                        No. of Machine :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="machine_number" value="<?php echo $row->machine_number; ?>" size="54" maxlength="10"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" width="28%">
                                        Production Capacity/ Day :
                                        </td>
                                        <!--<td >
                                        <input class="text_area" type="text" name="production_capacity" value="<?php // echo $row->production_capacity; ?>" size="54" maxlength="30" />
                                        </td>-->
                                        <td >
                                        <input class="text_area" type="text" name="production_capacity" value="<?php echo $row->production_capacity; ?>" size="20" maxlength="15" onKeyUp="javascript:check_IntNumber('production_capacity','Enter a valid number');" />
                                        &nbsp; Unit : <input class="text_area" type="text" name="production_unit" value="<?php echo $row->production_unit; ?>" size="15" maxlength="15" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Vat Reg. No :
                                        </td>
                                        <td >
                                        <input type="text" name="vat_reg_no" class="inputbox" size="50" maxlength="20" value="" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Vat Reg. Issue Date :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="vat_reg_issue_date" id="vat_reg_issue_date" value="" size="25" readonly  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img9" border=0 class="calender_link">
                                         <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                 </table>

                                 </td>
                                 </tr>
                                 <tr>
                                 <td>
                                 <table>
                                  <tr width=100% height="30">
                                        <td align="center" colspan="2" valign="bottom">
                                        <b>Proposer Information</b>
                                        </td>
                                </tr>

                                <!--tr width=100%>
                                        <td  align="right">
                                        Title :
                                        </td>
                                        <td >
                                        <?php echo $lists['proposer_one_title']; ?>
                                        </td>
                                </tr-->
                                <tr width=100%>
                                        <td  align="right">
                                        Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_one_name" value="<?php echo $row->proposer_one_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                <!--tr width=100%>
                                        <td  align="right">
                                        Last Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_one_last_name" value="<?php echo $row->proposer_one_last_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr-->


                                <tr width=100%>
                                        <td align="right">
                                        Address :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="proposer_one_address" value="<?php echo $row->proposer_one_address; ?>" size="54" maxlength="255"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        Membership No. :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="proposer_one_member_reg_no" value="<?php echo $row->proposer_one_member_reg_no; ?>" size="54" maxlength="20"  />
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
                                 <td>
                                 <table> <tr width=100% height="30">
                                        <td align="center" colspan="2" valign="bottom">
                                        <b>Seconder Information</b>
                                        </td>
                                </tr>

                                <!--tr width=100%>
                                        <td  align="right">
                                        Title :
                                        </td>
                                        <td >
                                        <?php echo $lists['proposer_two_title']; ?>
                                        </td>
                                </tr-->
                                <tr width=100%>
                                        <td  align="right">
                                        Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_two_name" value="<?php echo $row->proposer_two_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr>
                                <!--tr width=100%>
                                        <td  align="right">

                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="proposer_two_last_name" value="<?php echo $row->proposer_two_last_name; ?>" size="54" maxlength="25"  />
                                        </td>
                                </tr-->
                                <tr width=100%>
                                        <td align="right">
                                        Address :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="proposer_two_address" value="<?php echo $row->proposer_two_address; ?>" size="54" maxlength="255"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        Membership No. :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="proposer_two_member_reg_no" value="<?php echo $row->proposer_two_member_reg_no; ?>" size="54" maxlength="20"  />
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
                                 </table>
                                </td>
                                </tr>
                                <!-- modified by mizan end-->





                                 <!-- Modified by mizan start-->


                                <!-- modified by mizan start-->

                                <tr width=100% >
                                <td valign="top" colspan="2" align="center">
                                <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr width="100%" height="50">

                                        <td width="50%" align="center" valign="middle" colspan="2">
                                        <b>Enclosed Copy of :</b>
                                        </td>
                                </tr>
                                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];
                if ($i%2==0){
                ?>
                <tr width="100%">

                                        <td align="right">
                                        <!--input class="text_area" type="text" name="representative_designation" value="<?php echo $_SESSION['representative_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php
                                        if ($row->mendatory==1){
                                        echo "<input type='hidden' name='check_enclosure[]' value='$row->id'>";
                                        echo "* ".$row->caption;
                                        }
                                        else{
                                        echo "<input type='hidden' name='check_enclosure[]' value='0'>";
                                        echo $row->caption;
                                        }
                                        ?> :&nbsp;<input class="text_area" type="checkbox" name="enclosure[]" value="<?php echo $row->id;?>" />
                                                   <input type='hidden' name='message[]' value='<?php echo $row->message;?>'>
                                                   <input type='hidden' name='enc[]' value='<?php echo $row->id;?>'>
                                        </td>


                <?php
                }
                else{
                ?>

                                        <td align="right">

                                        <?php
                                         if ($row->mendatory==1){
                                        echo "<input type='hidden' name='check_enclosure[]' value='$row->id'>";
                                        echo "* ".$row->caption;
                                        }
                                        else{
                                        echo "<input type='hidden' name='check_enclosure[]' value='0'>";
                                        echo $row->caption;
                                        }
                                        ?> :&nbsp;<input class="text_area" type="checkbox" name="enclosure[]" value="<?php echo $row->id;?>" />
                                                   <input type='hidden' name='message[]' value='<?php echo $row->message;?>'>
                                                   <input type='hidden' name='enc[]' value='<?php echo $row->id;?>'>
                                        </td>

                                </tr>
                <?php
                }
                }
                ?>


                  </table>
                            </td>
                        </tr>

                                <!-- modified by mizan end-->

                                <!--tr width=100%>
                                        <td height=10 align="right" colspan=2>&nbsp;
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right >No. of Employee :</td>
                                        <td >
                                        <input class="text_area" type="text" name="employee_male" size="10" maxlength="6" value="<?php echo $_SESSION['employee_male']; ?>" onKeyUp="javascript:check_IntNumber('employee_male',2);" />
                                        : Male &nbsp;&nbsp;&nbsp;
                                        <input class="text_area" type="text" name="employee_female" size="10" maxlength="6" value="<?php echo $_SESSION['employee_female']; ?>" onKeyUp="javascript:check_IntNumber('employee_female',3);" />
                                        : Female &nbsp;&nbsp;&nbsp;
                                        <input class="text_area" type="text" name="employee_total" size="12" maxlength="20" readonly=true value="<?php echo $_SESSION['employee_total']; ?>" />
                                        Total
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        Production Capacity :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="production_capacity" value="<?php echo $_SESSION['production_capacity']; ?>" size="25" maxlength="125" onKeyUp="javascript:check_IntNumber('production_capacity',4);" />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        Established Year :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="establishment_year" value="<?php echo $_SESSION['establishment_year']; ?>" size="25" maxlength="4"  onKeyUp="javascript:check_IntNumber('establishment_year',1);" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                         Country of Incorporation :
                                        </td>
                                        <td >
                                        <?php echo $lists['country_id']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                         Location :
                                        </td>
                                        <td >
                                        <?php echo $lists['location']; ?>
                                        </td>
                                </tr-->
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
                        inputField     :    "commencing_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img3",   // trigger for the calendar (button ID)
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
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "import_reg_no_expire_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img6",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });
                </script>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "export_reg_no_expire_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img7",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });
                        
						Calendar.setup({
                        inputField     :    "bond_licence_issue_date",         // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,             // will display a time selector
                        button         :    "img8",            // trigger for the calendar (button ID)
                        singleClick    :    true,              // double-click mode
                        step           :    1                  // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "vat_reg_issue_date",         // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,             // will display a time selector
                        button         :    "img9",            // trigger for the calendar (button ID)
                        singleClick    :    true,              // double-click mode
                        step           :    1                  // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                </script>
                <?php
        }



}
?>
