<?php
/**
* @version $Id: admin.membership_edit_bkmea.html.php,v 1.16 2007/01/22 09:16:41 morshed Exp $
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

        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                <?php echo $image; ?>
                </a>
        <?php
        }

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
                        <th class="name" align="left" width=35%>
                        Applicant Name
                        </th>
                        <th class="name" align="left" width=15%>
                        Member Category
                        </th>
                        <th class="type" align="left" with=15%>
                        Member Type
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
                                <td>
                                <a class ="underline" href="<?php echo $link; ?>" title="Edit Membership">
                                <?php echo stripslashes($row->firm_name); ?>
                                </a>
                                </td>
                                <td>
                                <?php echo stripslashes($row->applicant_name); ?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->category); ?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->type); ?>
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
        function editMembershipA(&$member_inc,&$rows, &$lists, $option, $id, $start_date, $end_date,&$rows_manufacturer  ) {
                global $mosConfig_live_site,$mosconfig_calender_date_format;
                   $tabs = new mosTabs(1);
                   $year=date('Y');
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
                     msg=mid;
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


                                form.office_address_street.value=form.applicant_address_street.value;
                                form.office_address_town_suburb.value=form.applicant_address_town_suburb.value;
                                form.office_address_district.value=form.applicant_address_district.value;
                                form.office_address_division.value=form.applicant_address_division.value;
                                form.office_address_country.value=form.applicant_address_country.value;
                               // form.office_phone.value=form.applicant_office_phone.value;
                                form.office_fax.value=form.applicant_fax.value;
                                form.office_mobile.value=form.applicant_mobile.value;
                                form.office_email.value=form.applicant_email.value;

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

                function copy_propietor_information(){
                         var form = document.adminForm;
                        if (form.check_propietor_information.checked==true){
                                form.representative_title.value="";
                                form.representative_name.value="";
                                form.representative_last_name.value="";
                                form.representative_designation.value="";

                                form.representative_title.value=form.applicant_title.value;
                                form.representative_name.value=form.applicant_name.value;
                                form.representative_last_name.value=form.applicant_last_name.value;
                                form.representative_designation.value=8;
                                //form.elements['up_file[]'][1].value=form.elements['up_file[]'][0].value;


                        }
                }
                function submitbutton(pressbutton) {

                         //alert(document.adminForm.tabselection.value);

                        var form = document.adminForm;
                        var start, end, reg;
                        var flag=0;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        reg   =trim(form.last_reg_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(document.adminForm.tabselection.value=="0")
                        {
                                if(form.type_id.value == "0"){
                                     alert("You must select a member type ");
                                     form.type_id.focus();
                                }else if(form.last_reg_year_id.value == "0" ){
                                     alert("Registration year cannot be blank");
                                     form.last_reg_year_id.focus();
                                }else if(form.member_reg_no.value == "" ){
                                     alert("Membership code cannot be blank");
                                     form.member_reg_no.focus();
                                }else if(form.last_reg_date.value == "0000-00-00" || form.last_reg_date.value ==""){
                                     alert("Enter valid registration date");
                                     form.last_reg_date.focus();
                                 }else if(reg.getTime()<start.getTime() || reg.getTime()>end.getTime()){
                                     alert("Registration date must be between "+form.start_date.value+" and "+form.end_date.value);
                                     form.last_reg_date.focus();
                                 }else if(form.firm_name.value == ""){
                                     alert("Name of the firm cannot be blank");
                                     form.firm_name.focus();
                                 }/*else if(form.corporate_status.value == "0"){
                                     alert("You must select Corporate status");
                                     form.corporate_status.focus();
                                 }*/else if(trim (form.money_receipt_no.value) == ""){
                                     alert("Enter money receipt number");
                                     form.money_receipt_no.focus();
                                 }else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value ==""){
                                     alert("Enter valid money receipt date");
                                     form.money_receipt_date.focus();
                                 }else
                                   submitform( pressbutton );

                        }else if(document.adminForm.tabselection.value=="1"){
                                if(form.applicant_address_street.value == "0"){
                                     alert("You must enter the street / area of factory address ");
                                     form.applicant_address_street.focus();
                                }else if(form.applicant_email.value != "" && echeck(form.applicant_email.value)==false){

                                              form.applicant_email.focus();
                                }
                                else if(form.elements['location'].value ==0){
                                     bln_error=true;
                                     alert("Please select a location");
                                     form.location.focus();
                                }
                                else if(form.office_email.value != "" && echeck(form.office_email.value)==false){

                                     form.office_email.focus();
                                }else
                                          submitform( pressbutton );

                        }else if (document.adminForm.tabselection.value=="4"){
                                start =trim(form.trade_licence_issue_date.value);
                                  end   =trim(form.trade_licence_expire_date.value);

                                  start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                                  end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);

                                  /*if(trim(form.trade_licence_no.value) == ""){
                                           alert("Trade License No. can't be blank");
                                           form.trade_licence_no.focus();
                                    }else if(trim(form.trade_licence_issued_by.value) == ""){
                                           alert("Authority of Trade License can't be blank");
                                           form.trade_licence_issued_by.focus();
                                    }else if(trim(form.trade_licence_issue_date.value) == ""){
                                           alert("Trade License issue date can't be blank");
                                           form.trade_licence_issue_date.focus();
                                    }else if(trim(form.trade_licence_expire_date.value) == ""){
                                           alert("Trade License expire date can't be blank");
                                           form.trade_licence_expire_date.focus();
                                    }else*/ if(trim(form.trade_licence_issue_date.value) != "" && start.getTime()>end.getTime()  ){
                                           alert("Issued date cannot be greater than expiry date");
                                           form.trade_licence_issued_by.focus();
                                    }else{
                                                   submitform( pressbutton );
                                    }
                        }else if (document.adminForm.tabselection.value=="7"){


                                     for (i=0;i<form.elements['enclosure[]'].length;i++){
                                            if (form.elements['enclosure[]'][i].value==form.elements['check_enclosure[]'][i].value){
                                                if (form.elements['enclosure[]'][i].checked==false){

                                                 alert(form.elements['message[]'][i].value);
                                                 form.elements['enclosure[]'][i].focus();
                                                 //flag=1;
                                                 break;
                                                 //return;
                                               }
                                            }

                                      }

                                    if(i<=form.elements['enclosure[]'].length-1)
                                    {
                                            flag=1;
                                    }
                                    if (flag==0)
                                    {

                                               submitform( pressbutton );
                                    }
                                    else{
                                            flag=0;
                                            return;
                                    }
                        }else{
                                submitform( pressbutton );
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
                <form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
                <input type="hidden" name="tabselection">
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
                <?php
                $tabs->startPane("MemberPane");

                $tabs->startTab("General","General-page");
                ?>

                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        Details <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>
                               <tr width=100%>
                                        <td  width="25%" align="right">
                                        * Member Type :
                                        </td>
                                        <td width="75%">
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Member Category :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['member_category_id']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Member Status :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['member_status']; ?>
                                        </td>
                                </tr>

								<tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Year :</div>
                                        </td>
                                        <td >
                                        <b><?php echo 'Year '.date('Y',strtotime($_SESSION['reg_date'])); ?></b>
                                       </td>
                                </tr>
                                  <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Last Renewed Year :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['last_reg_year_id']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Last Renewed Date :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="last_reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['last_reg_date']); ?>" size="20"  readonly=true />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                <!--tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Voter :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['is_voter']; ?>
                                        </td>
                                </tr-->
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right></div>
                                        </td>
                                        <td >

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Membership No :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $_SESSION['member_reg_no']; ?>" size="30" maxlength="50"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Date of Commencing :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="commencing_date" id="commencing_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['commencing_date']); ?>" size="20" maxlength="255" readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img5" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Direct Export :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['is_direct_export']; ?>
                                        </td>
                                </tr>
                              <!--tr width=100%>
                                        <td height=24 align="center" colspan=2 valign=bottom>
                                        <b>Bank Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Bank Name :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bank_name" value="<?php echo $_SESSION['bank_name']; ?>" size="50" maxlength="50"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bank_address" value="<?php echo $_SESSION['bank_address']; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr-->
                                <tr width=100%>
                                        <td height=24 align="center" colspan=2 valign=bottom>
                                        <b>Applicant Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Name of the Firm :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="firm_name" value="<?php echo $_SESSION['firm_name']; ?>" size="57" maxlength="150"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Name of the Applicant :</div>
                                        </td>
                                        <td >

                                        <?php echo $lists['applicant_title'];?>
                                        &nbsp;&nbsp;First Name
                                        <input class="text_area" type="text" name="applicant_name" value="<?php echo $_SESSION['applicant_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp;Last Name
                                        <input class="text_area" type="text" name="applicant_last_name" value="<?php echo $_SESSION['applicant_last_name']; ?>" size="25" maxlength="25"  />
                                        </td>

                                </tr>
                                 <tr width=100%>
                                        <td  align="right">
                                         Designation:
                                        </td>
                                        <td >
                                        <?php echo $lists['applicant_designation']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Phone (Office) :</div>
                                        </td>
                                        <td >

                                        <input class="text_area" type="text" name="applicant_office_phone" value="<?php echo $_SESSION['applicant_office_phone']; ?>" size="21" maxlength="50"  />
                                        &nbsp;&nbsp;(Res) :
                                        <input class="text_area" type="text" name="applicant_home_phone" value="<?php echo $_SESSION['applicant_home_phone']; ?>" size="22" maxlength="50"  />
                                        &nbsp;&nbsp;(Factory) :
                                        <input class="text_area" type="text" name="office_phone" value="<?php echo $_SESSION['office_phone']; ?>" size="21" maxlength="50"  />
                                    &nbsp;(<b>Ex. 88-02-1042215</b>)
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td height=24 align="center" colspan=2 valign=bottom>
                                        <b>Money Receipt Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $_SESSION['money_receipt_no']; ?>" size="50" maxlength="15"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Money Receipt Date :</div>
                                        </td>
                                        <td >
                                        <input readonly class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['money_receipt_date']); ?>" size="20"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Membership with Chamber/ Association
                                        </td>
                                        <td >
                                        <?php echo $lists['association_list']; ?>

                                        </td>
                                </tr>

                           </table>
<?php
                $tabs->endTab();
                $tabs->startTab("Address","Address-page");
?>                             <table class="adminform">
                                            <tr width=100%>
                                    <td height=26 align="center" colspan=2 valign=bottom>
                                        <b>Factory Address</b>
                                    </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        * Street/Area :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="applicant_address_street" value="<?php echo $_SESSION['applicant_address_street']; ?>" size="57" maxlength="100"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        Thana / Upazilla :
                                        </td>
                                        <td  >
                                        <input class="text_area" type="text" name="applicant_address_town_suburb" value="<?php echo $_SESSION['applicant_address_town_suburb']; ?>" size="22" maxlength="30"  />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                        <input class="text_area" type="text" name="applicant_address_district" value="<?php echo $_SESSION['applicant_address_district']; ?>" size="22" maxlength="30"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        Division :
                                        </td>
                                        <td  >
                                        <input class="text_area" type="text" name="applicant_address_division" value="<?php echo $_SESSION['applicant_address_division']; ?>" size="22" maxlength="20"  />
                                        &nbsp;&nbsp;&nbsp;Country :
                                        <input class="text_area" type="text" name="applicant_address_country" value="<?php echo $_SESSION['applicant_address_country']; ?>" size="22" maxlength="30"  />
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Fax :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="applicant_fax" value="<?php echo $_SESSION['applicant_fax']; ?>" size="22" maxlength="50"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Mobile :
                                        <input class="text_area" type="text" name="applicant_mobile" value="<?php echo $_SESSION['applicant_mobile']; ?>" size="22" maxlength="30"  />
                                        &nbsp;(<b>Ex. 88-02-1042215</b>)
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Email address :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="applicant_email" value="<?php echo $_SESSION['applicant_email']; ?>" size="57" maxlength="125"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                            <td  align="right">
                                                    Web Address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="applicant_web" value="<?php echo $_SESSION['applicant_web']; ?>" size="57" maxlength="125"  />
                                                    </td>
                                            </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right></div>
                                        </td>
                                        <td >

                                        </td>
                                </tr>
                                <tr width=100%>
                                    <td height=26 align="center" colspan=2 valign=bottom>
                                        <b>Office Address</b>
                                        <input class="text_area" type="checkbox" name="check_firm_address" onClick="javascript:copy_firm_address();" /> Copy Factory Address
                                    </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        Street/Area :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_address_street" value="<?php echo $_SESSION['office_address_street']; ?>" size="57" maxlength="100"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        Thana / Upazilla :
                                        </td>
                                        <td  >
                                        <input class="text_area" type="text" name="office_address_town_suburb" value="<?php echo $_SESSION['office_address_town_suburb']; ?>" size="22" maxlength="30"  />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                        <input class="text_area" type="text" name="office_address_district" value="<?php echo $_SESSION['office_address_district']; ?>" size="22" maxlength="30"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" >
                                        Division :
                                        </td>
                                        <td  >
                                        <input class="text_area" type="text" name="office_address_division" value="<?php echo $_SESSION['office_address_division']; ?>" size="22" maxlength="20"  />
                                        &nbsp;&nbsp;&nbsp;Country :
                                        <input class="text_area" type="text" name="office_address_country" value="<?php echo $_SESSION['office_address_country']; ?>" size="22" maxlength="30"  />
                                        </td>
                                </tr>

                               <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Fax :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_fax" value="<?php echo $_SESSION['office_fax']; ?>" size="22" maxlength="30"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Mobile :
                                        <input class="text_area" type="text" name="office_mobile" value="<?php echo $_SESSION['office_mobile']; ?>" size="22" maxlength="30"  />
                                        &nbsp;(<b>Ex. 88-02-1042215</b>)
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Email Address :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_email" value="<?php echo $_SESSION['office_email']; ?>" size="57" maxlength="125"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Web address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_web" value="<?php echo $_SESSION['office_web']; ?>" size="57" maxlength="125"  />
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


                            </table>
<?php
$tabs->endTab();
$tabs->startTab("Capacity","Capacity-page");
?>
                      <table class="adminform">
                                 <tr >
                                        <td align=right >[No of Employee] Male :</td>
                                        <td >
                                        <input class="text_area" type="text" name="employee_male" size="10" maxlength="6" value="<?php echo $_SESSION['employee_male']; ?>" onKeyUp="javascript:check_IntNumber('employee_male',2);" />
                                        &nbsp;Female :
                                        <input class="text_area" type="text" name="employee_female" size="10" maxlength="6" value="<?php echo $_SESSION['employee_female']; ?>" onKeyUp="javascript:check_IntNumber('employee_female',3);" />
                                         &nbsp;&nbsp;Total :
                                        <input class="text_area" type="text" name="employee_total" size="12" maxlength="20" readonly=true value="<?php echo $_SESSION['employee_total']; ?>" />

                                        </td>
                                </tr>

                                <tr>
                                        <td  align="right" width=30%>
                                        Production Capacity / Day :
                                        </td>
                                        <!--<td width=70%>
                                        <input class="text_area" type="text" name="production_capacity" value="<?php //echo $_SESSION['production_capacity']; ?>" size="25" maxlength="30" />
                                         <?php //echo $lists['production_unit'];?>
                                        </td>-->
                                         <td width=70%>
                                        <input class="text_area" type="text" name="production_capacity" value="<?php echo $_SESSION['production_capacity'] ?>" size="20" maxlength="15" onKeyUp="javascript:check_IntNumber('production_capacity','Enter a valid number');" />
                                        &nbsp; Unit : <input class="text_area" type="text" name="production_unit" value="<?php echo $_SESSION['production_unit'] ?>" size="15" maxlength="15" />
                                        </td>
                                </tr>





                                <tr width=100%>
                                        <td  align="right">
                                        Number of Machine :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="machine_number"  size="25" maxlength="6"  value="<?php echo $_SESSION['machine_number']; ?>" onKeyUp="javascript:check_IntNumber('machine_number','Enter Valid Number of Machine');" />
                                        </td>
                                </tr>
                                   <tr width=100%>
                                        <td  align="right">
                                        Investment :
                                        </td>
                                        <td >
                                        <?php
                                        $investment_temp=bcdiv($_SESSION['investment'],1000000,3);
                                        if (intval($investment_temp)==bcadd($investment_temp,0,3))
                                            $investment=intval($investment_temp);
                                        else
                                            $investment=bcadd($investment_temp,0,3);

                                        ?>
                                        <input class="text_area" type="text" name="investment" size="25" maxlength="10"  value="<?php echo $investment; ?>" onKeyUp="javascript:check_FloatNumber('investment','Enter Valid Investment Amount');" />
                                        &nbsp;Million Tk.</td>
                                </tr>




                                <tr>
                                        <td  height=30 valign=bottom align="center" width=100% colspan=2>
                                        <b>Turnover Information </b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="center" colspan=2>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                        <td>
                                        <b>Year</b>
                                        </td>
                                        <td>
                                        <b><?php echo ($year-5); ?> </b>
                                        </td>
                                        <td>
                                        <b><?php echo ($year-4); ?> </b>
                                        </td>
                                        <td>
                                        <b><?php echo ($year-3); ?> </b>
                                        </td>
                                        <td>
                                        <b><?php echo ($year-2); ?> </b>
                                        </td>
                                        <td>
                                       <b><?php echo ($year-1); ?> </b>
                                        </td>
                                        </tr>

                                        <tr>
                                        <!--td>
                                        Local Sales
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_local_sales_1" value="<?php echo $_SESSION['financial_local_sales_1']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_local_sales_1','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_local_sales_2" value="<?php echo $_SESSION['financial_local_sales_2']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_local_sales_2','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_local_sales_3" value="<?php echo $_SESSION['financial_local_sales_3']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_local_sales_3','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_local_sales_4" value="<?php echo $_SESSION['financial_local_sales_4']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_local_sales_4','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_local_sales_5" value="<?php echo $_SESSION['financial_local_sales_5']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_local_sales_5','Enter Valid Number');" />
                                        </td-->
                                        </tr>

                                        <tr>
                                        <td>
                                        Export Sales
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_export_sales_1" value="<?php echo $_SESSION['financial_export_sales_1']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_export_sales_1','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_export_sales_2" value="<?php echo $_SESSION['financial_export_sales_2']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_export_sales_2','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_export_sales_3" value="<?php echo $_SESSION['financial_export_sales_3']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_export_sales_3','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_export_sales_4" value="<?php echo $_SESSION['financial_export_sales_4']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_export_sales_4','Enter Valid Number');" />
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="financial_export_sales_5" value="<?php echo $_SESSION['financial_export_sales_5']; ?>" size="10" maxlength="10" onkeyup="javascript:check_IntNumber('financial_export_sales_5','Enter Valid Number');" />
                                        </td>
                                        </tr>

                                        </table>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right"   valign=bottom width=10%>
                                        Turn Over Volume (USD)
                                        </td>
                                        <td width=90%>
                                        <input class="text_area" type="text" name="financial_turnover_volume" value="<?php echo $_SESSION['financial_turnover_volume']; ?>" size="30" maxlength="15"  onkeyup="javascript:check_IntNumber('financial_turnover_volume','Enter valid Turn Over Volume');" />
                                        </td>
                                </tr>
                                <tr width=100% >
                                        <td colspan="2" align=center>
                                        <b> <u>Machine List Of The Member</u></b>
                                        <?php
                                           echo " <A class=toolbar href='index2.php?option=com_membership_edit_bkmea&task=editA&id=$id&hidemainmenu=1&opt=add_m'>Add new</a>";
                                        ?>
                                        </td>
                                </tr>
                                <tr>
                                <td  align=center colspan="2" >
                                <center>
                                <table width=60%>

                                <tr width=100%>
                                        <td width=15%>
                                        <b>Sl No.</b>
                                        </td>
                                        <td width=50%>
                                        <b>Machine Name</b>
                                        </td>
                                        <td  width=35%>
                                        <b>Quantity</b>
                                        </td>

                                </tr>      <!-- last edit start-->

                                <?php
                                for($i=1; $i<=$_SESSION['total_member_machine']; $i++){
                                        $machine_id="m_".$i."_id";
                                        $machine_name="m_".$i."_machine_name";
                                        $quantity="m_".$i."_quantity";

                                ?>
                                <tr >
                                        <td >
                                        <b><?php echo $i; ?></b>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $machine_name; ?>" value="<?php echo $_SESSION[$machine_name]; ?>" size="50" maxlength="30"  />
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $quantity;   ?>" value="<?php echo $_SESSION[$quantity]; ?>" size="15" maxlength="30" onKeyUp="javascript:check_IntNumber('<? echo $quantity; ?>','Enter valid Quantity');" />
                                        </td>
                                </tr>
                                <? } ?>
                                </table>
                                </center>
                                </td>
                                </tr>
                            </table>
<?php
$tabs->endTab();
$tabs->startTab("Representative","Representative-page");
?>
                            <table class="adminform">
                                <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">
                                        <!--input class="text_area" type="checkbox" name="check_propietor_information" onClick="javascript:copy_propietor_information();" /-->
                                        &nbsp;<b>Representative Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>

                                        <td  align="right" >
                                         Name of the Representative :
                                        </td>
                                        <td >

                                        <?php echo $lists['representative_title'];?>
                                        &nbsp;&nbsp;First Name
                                        <input class="text_area" type="text" name="representative_name" value="<?php echo $_SESSION['representative_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp;Last Name
                                        <input class="text_area" type="text" name="representative_last_name" value="<?php echo $_SESSION['representative_last_name']; ?>" size="25" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                         Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="representative_designation" value="<?php echo $_SESSION['representative_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['representative_designation']; ?>
                                        </td>
                                </tr>

                                 <tr width=100%>
                                        <td  align="right">
                                         Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="representative_mobile" value="<?php echo $_SESSION['representative_mobile']; ?>" size="21" maxlength="25"  />
                                        &nbsp;(<b>Ex. 88-02-1042215</b>)
                                        </td>
                                </tr>

                                 <tr>
                        <td width="100%" valign="top" colspan=2>
                                <table class="adminform">

                               <tr width=100% >
                                        <td colspan="4" align=center>
                                        <b> <u>Proprietor / Director</u></b>
                                         <?php


                                           echo " <A class=toolbar href='index2.php?option=com_membership_edit_bkmea&task=editA&id=$id&hidemainmenu=1&opt=add_d'>Add new</a>";
                                         ?>
                                         <!--a class="toolbar" href="javascript:hideMainMenu();submitbutton_add('<?php echo $opt; ?>');" > Add New</a-->
                                         </td>
                                </tr>
                                <tr width=100%>
                                        <td  align=right>
                                        <b>SL No</b>
                                        </td>
                                        <td  >
                                        <b>Name</b>
                                        </td>
                                        <td >
                                        <b>Cell Phone</b>
                                        </td>
                                        <td   >
                                        <b>Office Phone </b>
                                        </td>
                                </tr>
                                <?php
                                for($i=1; $i<=$_SESSION['total_director']; $i++){
                                        $director_id = "d_".$i."_id";
                                        $director_name = "d_".$i."_name";
                                        $director_home_phone = "d_".$i."_home_phone";
                                        $director_office_phone = "d_".$i."_office_phone";

                                ?>
                                <tr width=100%>
                                        <td  align=middle>
                                        <b><? echo $i; ?></b>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $director_name; ?>" value="<?php echo $_SESSION[$director_name]; ?>" size="50" maxlength="50"  />
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $director_office_phone; ?>" value="<?php echo $_SESSION[$director_office_phone]; ?>" size="15" maxlength="30"  />
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $director_home_phone;   ?>" value="<?php echo $_SESSION[$director_home_phone]; ?>" size="15" maxlength="30"  />
                                        </td>
                                </tr>
                                <? } ?>
                            </table>
                            </td>
                        </tr>
                        </table>
<?php
$tabs->endTab();
$tabs->startTab("License","License");
?>
                            <table class="adminform">
                            <tr width=100%>
                                        <td  height=24 align="left" colspan=4 valign=bottom>
                                        <b>Information of License</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" width="25%">
                                         Trade License Number :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_no" value="<?php echo $_SESSION['trade_licence_no']; ?>" size="28" maxlength="20"  />
                                        </td>
                                        <td  align="right">
                                        Import Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="import_reg_no" value="<?php echo $_SESSION['import_reg_no']; ?>" size="28" maxlength="20"  />
                                        </td>


                                </tr>
                                <tr width=100%>
                                        <td align="right" width="25%">
                                         Name of the Issued Authority :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="<?php echo $_SESSION['trade_licence_issued_by']; ?>" size="28" maxlength="50"  />
                                        </td>
                                        <td align="right">
                                       Expire Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="import_reg_no_expire_date" id="import_reg_no_expire_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['import_reg_no_expire_date']); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img9" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td align="right" width="25%">
                                         Issue Date :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_issue_date" id="trade_licence_issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['trade_licence_issue_date']); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img3" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                         <td  align="right">
                                        Export Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="export_reg_no" value="<?php echo $_SESSION['export_reg_no']; ?>" size="28" maxlength="20"  />
                                        </td>

                                </tr>
                                <tr width=100%>
                                         <td  align="right" width="25%">
                                        Expiry Date :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_expire_date" id="trade_licence_expire_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['trade_licence_expire_date']); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                        <td align="right">
                                        Expire Date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="export_reg_no_expire_date" id="export_reg_no_expire_date"  value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['export_reg_no_expire_date']); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img7" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                        <td>
                                        </td>

                                        <!--td  align="right">
                                        Registration Number under Factories Act :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="factory_act_reg_no" value="<?php echo $_SESSION['factory_act_reg_no']; ?>" size="28" maxlength="20"  />
                                        </td-->


                                </tr>
                                <tr>
                                        <td align=right>
                                        Bond License No :
                                        </td>
                                        <td >
                                        <input type="text" name="bond_licence_no" class="inputbox" size="28" maxlength="20" value="<?php echo $_SESSION['bond_licence_no']; ?>" />
                                        </td>
                                        <td align=right>
                                        Vat Reg. No :
                                        </td>
                                        <td >
                                        <input type="text" name="vat_reg_no" class="inputbox" size="28" maxlength="20" value="<?php echo $_SESSION['vat_reg_no']; ?>" />
                                        </td>
                                </tr>
                                
                                <tr>
                                        <td align=right>
                                        Bond License Date :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="bond_licence_issue_date" id="bond_licence_issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['bond_licence_issue_date']); ?>" size="20" readonly  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img8" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                        <td align=right>
                                        Vat Reg. Issue Date :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="vat_reg_issue_date" id="vat_reg_issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['vat_reg_issue_date']); ?>" size="20" readonly  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img10" border=0 class="calender_link">
                                         <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                                
                                <tr width=100%>
                                        <td  align="right">
                                        Tax Payers Identification number(TIN) :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="tin" value="<?php echo $_SESSION['tin']; ?>" size="28" maxlength="20"  />
                                        </td>

                                </tr>

                            </table>
<?php
$tabs->endTab();
$tabs->startTab("Proposer","Proposer");
?>
                            <table class="adminform">
                            <tr width=100%>
                                        <td  height=24 align="center" colspan=2 valign=bottom>
                                        <b>Proposer Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                         Proposer Name :
                                        </td>
                                        <td >

                                        <!--?php echo $lists['proposer_one_title']; ?-->



                                        <input class="text_area" type="text" name="proposer_one_name"  value="<?php echo $_SESSION['proposer_one_name']; ?>" size="50" maxlength="25"  />

                                        <!--input class="text_area" type="text" name="proposer_one_last_name" value="<?php echo $_SESSION['proposer_one_last_name']; ?>" size="25" maxlength="25"  /-->
                                        </td>
                                </tr>


                                <tr width=100%>
                                        <td width=30% align="right">
                                        Address :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_one_address" value="<?php echo $_SESSION['proposer_one_address']; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                         Membership No. :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_one_member_reg_no" value="<?php echo $_SESSION['proposer_one_member_reg_no']; ?>" size="50" maxlength="20"  />
                                        </td>
                                </tr>
                                    <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Proposer' onclick=javascript:newwindow(1); />
                                                        </td>
                                 </tr>

                                <tr width =100% hight=30>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                         Proposer Two Name :
                                        </td>
                                        <td >
                                        <!--?php echo $lists['proposer_two_title']; ?-->

                                        <input class="text_area" type="text" name="proposer_two_name" value="<?php echo $_SESSION['proposer_two_name']; ?>" size="50" maxlength="25"  />

                                        <!--input class="text_area" type="text" name="proposer_two_last_name" readonly value="<?php echo $_SESSION['proposer_two_last_name']; ?>" size="25" maxlength="25"  /-->
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        Address :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_two_address" value="<?php echo $_SESSION['proposer_two_address']; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                         Membership No. :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_two_member_reg_no" value="<?php echo $_SESSION['proposer_two_member_reg_no']; ?>" size="50" maxlength="20"  />
                                        </td>
                                </tr>
                                <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Seconder' onclick=javascript:newwindow(2); />
                                                        </td>
                                 </tr>
                                <tr>



                            </table>
<?php
$tabs->endTab();
$tabs->startTab("Business Line","Businessline-page");
?>
                            <table class="adminform">
                         <tr>
                          <td width="100%" valign="top" colspan=2>
                                <table class="adminform">

                                <tr width=100% >
                                        <td colspan="7" align=center>
                                        <b> <u>Records of Export made since Commencement</u></b>
                                        <?php
                                           echo " <A class=toolbar href='index2.php?option=com_membership_edit_bkmea&task=editA&id=$id&hidemainmenu=1&opt=add_e'>Add new</a>";
                                        ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  >
                                        <b>L/C Number</b>
                                        </td>
                                        <td >
                                        <b>L/C Date</b>
                                        </td>
                                        <td   >
                                        <b>Importing Firm </b>
                                        </td>
                                        <td  >
                                        <b>Importing Country</b>
                                        </td>
                                        <td  >
                                        <b>Export Category</b>
                                        </td>
                                        <td  >
                                        <b>Quantity</b>
                                        </td>
                                        <td  >
                                        <b>Amount(USD)</b>
                                        </td>
                                </tr>
                                <?php
                                $cal_setup="<script type=\"text/javascript\">\n";
                                for($i=1; $i<=$_SESSION['total_expoter']; $i++){
                                        $e_lc_number = "e_".$i."_lc_number";
                                        $e_lc_date = "e_".$i."_lc_date";
                                        $e_importer_name = "e_".$i."_importer_name";
                                        $e_country_id = "e_".$i."_country_id";
                                        $e_cat_no_id = "e_".$i."_cat_no_id";
                                        $e_quantity = "e_".$i."_quantity";
                                        $e_amount = "e_".$i."_amount";
                                        $lists[$e_country_id]                         = mosAdminMenus::CountryList( $e_country_id, intval( $_SESSION[$e_country_id] ) );
                                        $lists[$e_cat_no_id]                          = mosAdminMenus::ExportCategory($e_cat_no_id, intval( $_SESSION[$e_cat_no_id] ) );

                                        $img_id="img".($i+100);
                                        $cal_setup.="\nCalendar.setup({"
                                                    ."\n inputField     :    \"".$e_lc_date."\","
                                                    ."\n ifFormat       :    \"".$mosconfig_calender_date_format."\","
                                                    ."\n showsTime      :    false,            "
                                                    ."\n button         :    \"".$img_id."\","
                                                    ."\n singleClick    :    true,"
                                                    ."\n step           :    1   "
                                                    ."\n });\n";


                                ?>
                                <tr width=100%>
                                <td  >
                                       <input class="text_area" type="text" name="<? echo $e_lc_number; ?>" value="<?php echo $_SESSION[$e_lc_number]; ?>" size="10" maxlength="20"  />
                                        </td>
                                        <td >
                                        <input class="text_area" readonly=true type="text" name="<? echo $e_lc_date; ?>" id="<?php echo $e_lc_date; ?>" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION[$e_lc_date]); ?>" size="10"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="<?php echo $img_id; ?>" border=0  class="calender_link">
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="<? echo $e_importer_name; ?>" value="<?php echo $_SESSION[$e_importer_name]; ?>" size="20" maxlength="50"  />
                                        </td>
                                        <td>
                                        <?php echo $lists[$e_country_id];  ?>
                                        </td>
                                        <td >
                                        <?php echo $lists[$e_cat_no_id]; ?>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $e_quantity; ?>" value="<?php echo $_SESSION[$e_quantity]; ?>" size="8" maxlength="50" onKeyUp="javascript:check_IntNumber('<? echo $e_quantity; ?>',3);" />
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $e_amount; ?>" value="<?php echo $_SESSION[$e_amount]; ?>" size="8" maxlength="20"  onkeyup="javascript:check_FloatNumber('<? echo $e_amount; ?>',1);"  />
                                        </td>

                                </tr>
                                <? } $cal_setup.="</script>"; ?>
                            </table>
                            </td>
                        </tr>
                                <tr width=100%>
                                        <td  align="right" valign=top width=50%>
                                        <table width=100%>
                                        <tr>
                                        <td align=right valign=top> Product Information : </td>
                                        <!--td> <?php echo $lists['product_list'];  ?>  </td-->
                                        <td align="left" valign="top">
                                        &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,3,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_manufacturer,$id,1,3,0);

                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                        </td>

                                        <td  width=50%>
                                        <table width=100%>
                                        <tr>
                                        <td align=right valign=top> Certificate on Compliance/ Quality/ Other :</td>
                                        <td> <?php echo $lists['compliance_list']; ?>  </td>
                                        </tr>
                                        </table>
                                        </td>
                                </tr>
                            </table>
<?php
$tabs->endTab();
$tabs->startTab("Enclosed Copy","Enclosed-page");
?>
                       <table class="adminform">
                         <tr>
                          <td width="100%" valign="top" >
                                 <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr width="100%" height="50">

                                        <td width="50%" align="center" valign="middle" colspan="2">
                                        <b>Enclosed Copy of : </b>

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




                                            echo "<input type='hidden' name='check_enclosure[]' value='$row->id' >";




                                        echo "* ".$row->caption;
                                        }
                                        else{
                                             echo "<input type='hidden' name='check_enclosure[]' value='0'><input type='hidden' name='enc[]' value='$row->id'>";
                                             echo $row->caption;
                                        }
                                        ?> :
                                                <?php for ($j=0, $k=count( $member_inc ); $j < $k; $j++) {
                                                   if ($row->id == $member_inc[$j]->enclosure_id)
                                                   {
                                                        if ($member_inc[$j]->enclosure_rule==1)

                                                          { $chk=1;
                                                            break;
                                                          }
                                                          else{
                                                                   $chk=0;
                                                                   break;
                                                               }
                                                   } else $chk=0;

                                                }
                                                if ($chk==0)
                                                    $checked="";
                                                else
                                                    $checked='checked';


                                                ?>
                                           &nbsp;<input class="text_area" type="checkbox" name="enclosure[]" <?php echo $checked;?> value="<?php echo $row->id;?>" />
                                                    <input type='hidden' name='message[]' value='<?php echo $row->message;?>'>
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
                                             echo "<input type='hidden' name='check_enclosure[]' value='0'><input type='hidden' name='enc[]' value='$row->id'>";
                                             echo $row->caption;
                                        }
                                        ?> :
                                         <?php for ($j=0, $k=count( $member_inc ); $j < $k; $j++) {
                                                   if ($row->id == $member_inc[$j]->enclosure_id)
                                                   {
                                                        if ($member_inc[$j]->enclosure_rule==1)

                                                          { $chk=1;
                                                            break;
                                                          }
                                                          else{
                                                                   $chk=0;
                                                                   break;
                                                               }
                                                   } else $chk=0;

                                                }
                                                if ($chk==0)
                                                    $checked="";
                                                else
                                                    $checked='checked';


                                                ?>
                                                &nbsp;<input class="text_area" type="checkbox" name="enclosure[]" <?php echo $checked;?> value="<?php echo $row->id;?>" />
                                                   <input type='hidden' name='message[]' value='<?php echo $row->message;?>'>
                                        </td>

                                </tr>
                       <?php
                     }
                }
                ?>


                  </table>


                         </td>
                          </tr>
                       </table>
<?php
$tabs->endTab();

$tabs->endPane() ;
?>
                            </td>
                        </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <!--input type="hidden" name="option" value="<?php echo $option;?>" /-->
                <input type="hidden" name="option" value="com_membership_edit_bkmea" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="step" value="1" />
                <input type="hidden" name="task" value="save" />
                <input type="hidden" name="hidemainmenu" value="0">
                </form>
                <script language="javascript" type="text/javascript">

                        Calendar.setup({
                        inputField     :    "reg_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });
                         Calendar.setup({
                        inputField     :    "commencing_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img5",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "trade_licence_expire_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "trade_licence_issue_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img3",   // trigger for the calendar (button ID)
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
                        inputField     :    "import_reg_no_expire_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img9",   // trigger for the calendar (button ID)
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
                        button         :    "img10",            // trigger for the calendar (button ID)
                        singleClick    :    true,              // double-click mode
                        step           :    1                  // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>

                 <script language="javascript" type="text/javascript">
                 var total_expoter="<?php echo $_SESSION['total_expoter']; ?>";
                 var obj ="e_"+total_expoter+"_lc_number";
                 var opt="<?php echo $opt; ?>";
                 //alert(total_expoter+" : "+curr_expoter);
                 if(opt=="add_e")
                 document.forms[0].elements[obj].value="";
                 //document.forms[0].elements[obj].focus();
                 </script>


                <?php
                    echo $cal_setup;
        }
        function businessLineInformation(&$rows,$member_id=0,$hscodeType=0,$businessType=0,$countryId=0){
                global $database;
                ?>
                <script language="javascript" type="text/javascript">
                <!--
                function popupHSCode(task, member_id, id, hscodeType, businessType, country){

                               var status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                               var link = 'components/com_hscode/admin.hscode.php?option=com_hscode&task='+task+'&member_id='+member_id+'&id='+id+'&hscodeType='+hscodeType+'&businessType='+businessType+'&country='+country;
                               void window.open(link, 'win2', status);
                }
                //-->
                </script>
                <?php
                     $sl=1;
                      foreach ($rows as $row){
                         $query="select pc.country_name as country_name from #__pshop_country as pc,#__member_product_country as mpc, #__member_product_line as mpl"
                                 ." where pc.country_id=mpc.country_id and mpc.member_product_id=mpl.id and mpl.member_id='$member_id' and mpl.business_type='$businessType' and mpl.product_id=".$row->id;
                         $database->setQuery( $query );
                         $rows_country = $database->loadObjectList();
                         $countryList="";
                         $country=array();
                         if (count($rows_country)>0){
                             $i=0;
                             foreach ($rows_country as $row_country){
                                  $country[$i]=$row_country->country_name;
                                  $i++;
                             }
                             $countryList=implode(", ",$country);
                         }
                         if (trim($countryList)!="")
                             $countryList="(".$countryList.")";
                         echo $sl.". ".$row->hscode.", ".$row->name."&nbsp;&nbsp;".$countryList."&nbsp;&nbsp;<a href=\"javascript:popupHSCode('edit',$member_id,$row->id,$hscodeType,$businessType,$countryId);\" style=\"text-decoration:none;\"><b>Edit</b></a>"."/&nbsp;<a href=\"index2.php?option=com_membership_edit_bkmea&task=dbli&member_id=$member_id&product_id=$row->id&businessType=$businessType&member_product_id=$row->member_product_id\" style=\"text-decoration:none;\"><b>Delete</b></a>"."<br>";
                         $sl++;
                      }
        }

}
?>
