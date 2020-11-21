<?php
/**
* @version $Id: admin.non_member_bkmea.html.php,v 1.5 2006/03/07 05:26:11 sami Exp $
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
                        <th class="firmname" width=45% align="left">
                        Firm Name
                        </th>
                        <th class="name" align="left" width=50%>
                        Applicant Name
                        </th>
                        <th class="name" align="left" width=20%>
                        Location
                        </th>


                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];

                        $link         = 'index2.php?option=com_non_member_bkmea&task=editA&hidemainmenu=1&id='. $row->id;

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
                                <?php echo stripslashes($row->applicant_title)." ".stripslashes($row->applicant_name)." ".stripslashes($row->applicant_last_name); ?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->location); ?>
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
        function editMembershipA(&$member_inc,&$rows, &$lists, $option, $id, $start_date, $end_date  ) {
                global $mosConfig_live_site,$mosconfig_calender_date_format;

                   if ($id!=0)
                   $tabs = new mosTabs(1);
                  else
                    $tabs = new mosTabs(0);

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
                                form.office_phone.value="";
                                form.office_fax.value="";
                                form.office_mobile.value="";
                                form.office_email.value="";


                                form.office_address_street.value=form.applicant_address_street.value;
                                form.office_address_town_suburb.value=form.applicant_address_town_suburb.value;
                                form.office_address_district.value=form.applicant_address_district.value;
                                form.office_address_division.value=form.applicant_address_division.value;
                                form.office_address_country.value=form.applicant_address_country.value;
                                form.office_phone.value=form.applicant_office_phone.value;
                                form.office_fax.value=form.applicant_fax.value;
                                form.office_mobile.value=form.applicant_mobile.value;
                                form.office_email.value=form.applicant_email.value;

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

                         //alert(document.adminForm.tabselection.value);

                        var form = document.adminForm;
                        var start, end, reg;
                        var flag=0;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        //reg   =trim(form.reg_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                       // reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(document.adminForm.tabselection.value=="0")
                        {
                                if(form.firm_name.value == ""){
                                     alert("Firm Name can't be blank");
                                     form.firm_name.focus();
                                 }/*else if(form.corporate_status.value == "0"){
                                     alert("You must select Corporate status");
                                     form.corporate_status.focus();
                                 }else if(trim (form.money_receipt_no.value) == ""){
                                     alert("Enter Money Receipt Number");
                                     form.money_receipt_no.focus();
                                 }else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value ==""){
                                     alert("Enter valid Money Receipt date");
                                     form.money_receipt_date.focus();
                                 }*/else if(form.applicant_designation.value == "0"){
                                        alert("You must enter Applicant Designation");
                                        form.applicant_designation.focus();
                                 }else
                                   submitform( pressbutton );

                        }else if(document.adminForm.tabselection.value=="1"){
                                if(form.applicant_address_street.value == ""){
                                     alert("You must Enter Street / Area in factory address ");
                                     form.applicant_address_street.focus();
                                }else if(form.applicant_email.value != "" && echeck(form.applicant_email.value)==false){

                                   form.applicant_email.focus();
                                }else if(form.office_email.value != "" && echeck(form.office_email.value)==false){

                                         form.office_email.focus();
                                }else
                                   submitform( pressbutton );

                        }else if (document.adminForm.tabselection.value=="3"){
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
                                    }else*/ if(trim(form.trade_licence_issue_date.value) != "" && start.getTime()>end.getTime() ){
                                           alert("Issued date cannot be greater than Expire date");
                                           form.trade_licence_issued_by.focus();
                                    }/*else if(trim(form.tin.value) == ""){
                                           alert("Tax payers Identification No.an't be blank");
                                           form.tin.focus();
                                    }*/else{
                                                   submitform( pressbutton );
                                    }
                        }else{
                                submitform( pressbutton );
                        }

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
                                <tr width=100%>
                                        <td  align="right">
                                        * Designation :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="representative_designation" value="<?php echo $_SESSION['representative_designation']; ?>" size="50" maxlength="30"  /-->
                                        <?php echo $lists['applicant_designation']; ?>
                                        </td>
                                </tr>






                                <tr width=100%>
                                        <td height=24 align="center" colspan=2 valign=bottom>
                                        <b>Money Receipt Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $_SESSION['money_receipt_no']; ?>" size="50" maxlength="15"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Money Receipt Date :</div>
                                        </td>
                                        <td >
                                        <input readonly class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['money_receipt_date']); ?>" size="20"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>


                           </table>
<?php
                $tabs->endTab();

                if ($id!=0) {

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
                                        <div align=right>Phone 1 :</div>
                                        </td>
                                        <td >

                                        <input class="text_area" type="text" name="applicant_office_phone" value="<?php echo $_SESSION['applicant_office_phone']; ?>" size="21" maxlength="30"  />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone 2 :
                                        <input class="text_area" type="text" name="applicant_home_phone" value="<?php echo $_SESSION['applicant_home_phone']; ?>" size="22" maxlength="30"  />
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Fax :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="applicant_fax" value="<?php echo $_SESSION['applicant_fax']; ?>" size="22" maxlength="30"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Mobile :
                                        <input class="text_area" type="text" name="applicant_mobile" value="<?php echo $_SESSION['applicant_mobile']; ?>" size="22" maxlength="30"  />
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
                                        <div align=right>Phone :</div>
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="office_phone" value="<?php echo $_SESSION['office_phone']; ?>" size="57" maxlength="30"  />
                                        </td>
                                </tr>

                               <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Fax :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="office_fax" value="<?php echo $_SESSION['office_fax']; ?>" size="22" maxlength="30"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Mobile :
                                        <input class="text_area" type="text" name="office_mobile" value="<?php echo $_SESSION['office_mobile']; ?>" size="22" maxlength="30"  />
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
                                         Location :
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
                                        <td width=70%>
                                        <input class="text_area" type="text" name="production_capacity" value="<?php echo $_SESSION['production_capacity']; ?>" size="25" maxlength="125" onKeyUp="javascript:check_IntNumber('production_capacity','Enter valid Production Capacity');" />
                                         <?php echo $lists['production_unit'];?>
                                        </td>
                                </tr>





                                <tr width=100%>
                                        <td  align="right">
                                        Number of Machine Basic :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="machine_number"  size="25" maxlength="6"  value="<?php echo $_SESSION['machine_number']; ?>" onKeyUp="javascript:check_IntNumber('machine_number',3);" />
                                        </td>
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
                                        <td>
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
                                        </td>
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
                                <tr>
                          <td width="100%" valign="top" colspan=2>
                                <table class="adminform">

                                <tr width=100% >
                                        <td colspan="7" align=center>
                                        <b> <u>Machine List Of The Member</u></b>
                                        <?php
                                        //   echo " <A class=toolbar href='index2.php?option=com_membership_edit_bkmea&task=editA&id=$id&hidemainmenu=1&opt=add_m'>Add new</a>";
                                        ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align=right>
                                        <b>Machine</b>
                                        </td>

                                        <td >
                                        <b>Quantity</b>
                                        </td>

                                </tr>
                                <?php
                                  $j=1;
                                for($i=1; $i<$_SESSION['total_machine']; $i++){
                                        //$m_machine_id = "m_".$i."_machine_id";
                                        $machine_id="m_".$i."_id";
                                        $m_machine_id="mm_".$j."_machine_id";
                                        $machine_name="m_".$i."_machine_type";

                                        if ($_SESSION[$machine_id]==$_SESSION[$m_machine_id])
                                           {          // echo "pppppppppppppppppppppppppp";
                                             $ms_quantity = "mm_".$j."_quantity";
                                             $j++;
                                           }
                                        else $ms_quantity="";

                                        $m_quantity="mm_".$i."_quantity";
                                        //$mm_quatity=
                                        //echo "---".$m_machine_id;
                                        //$lists[$m_machine_id]                         = mosAdminMenus::Machine( $m_machine_id, intval( $_SESSION[$machine] ) );

                                        //echo "---".$m_machine_id;


                                ?>
                                <tr width=100%>
                                        <td align=right >
                                        <!--?php echo $lists[$m_machine_id];  ?-->
                                        <?php echo $_SESSION[$machine_name]; ?>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="<? echo $m_quantity; ?>" value="<?php echo $_SESSION[$ms_quantity]; ?>" size="10" maxlength="7" onKeyUp="javascript:check_IntNumber('<? echo $m_quantity; ?>','Enter Valid Number');" />
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
                                        <b>Trade License Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" width="25%">
                                         License Number :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_no" value="<?php echo $_SESSION['trade_licence_no']; ?>" size="20" maxlength="20"  />
                                        </td>
                                        <td  align="right">
                                        Impoter Reg. No :
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
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="<?php echo $_SESSION['trade_licence_issued_by']; ?>" size="20" maxlength="50"  />
                                        </td>
                                         <td  align="right">
                                        Expoter Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="export_reg_no" value="<?php echo $_SESSION['export_reg_no']; ?>" size="28" maxlength="20"  />
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
                                        Indenting Trade Number :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="indenting_trade_no" value="<?php echo $_SESSION['indenting_trade_no']; ?>" size="28" maxlength="20"  />
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
                                        <td>
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
                                           echo " <A class=toolbar href='index2.php?option=com_non_member_bkmea&task=editA&id=$id&hidemainmenu=1&opt=add_e'>Add new</a>";
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

                                        $img_id="img".($i+5);
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
                                        <td> <?php echo $lists['product_list'];  ?>  </td>
                                        </tr>
                                        </table>
                                        </td>

                                        <td  width=50%>
                                        <table width=100%>
                                        <tr>
                                        <td align=right valign=top> Compliance :</td>
                                        <td> <?php echo $lists['compliance_list']; ?>  </td>
                                        </tr>
                                        </table>
                                        </td>
                                </tr>
                            </table>
<?php
$tabs->endTab();
    }
  $tabs->endPane() ;
?>
                            </td>
                        </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <!--input type="hidden" name="option" value="<?php echo $option;?>" /-->
                <input type="hidden" name="option" value="com_non_member_bkmea" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="step" value="1" />
                <input type="hidden" name="task" value="save" />
                <input type="hidden" name="hidemainmenu" value="0">
                </form>
                <script type="text/javascript">

                      /*  Calendar.setup({
                        inputField     :    "reg_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        }); */

                         Calendar.setup({
                        inputField     :    "commencing_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img5",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });
                   <?php if ($id!=0) { ?>
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
                    <?php } ?>
                        Calendar.setup({
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img4",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
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

}
?>
