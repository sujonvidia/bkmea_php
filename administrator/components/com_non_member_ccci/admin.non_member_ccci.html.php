<?php
/**
* @version $Id: admin.non_member_ccci.html.php,v 1.3 2006/03/09 06:36:00 nnabi Exp $
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
                       Non Member Profile
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
                        <th class="firmname" width=40% align="left">
                        Firm Name
                        </th>
                        <th class="name" align="left" width=30%>
                        Applicant Name
                        </th>

                        <th class="type" align="left" with=15%>
                        Location
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];

                        $link         = 'index2.php?option=com_non_member_ccci&task=editA&hidemainmenu=1&id='. $row->id;


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
                                <?php echo stripslashes($row->applicant_name); ?>
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
        function editMembershipA( &$lists, $option, $id, $start_date, $end_date  ) {
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
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        //reg   =trim(form.reg_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        //reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(document.adminForm.tabselection.value=="0")
                        {
                                if(form.firm_name.value == ""){
                                     alert("Firm's Name cannot be blank");
                                     form.firm_name.focus();
                                 }else if(form.corporate_status.value == "0"){
                                     alert("You must select Corporate status");
                                     form.corporate_status.focus();
                                 }else if(form.applicant_name.value == ""){
                                       alert("Proprietor's name cannot be blank");
                                       form.applicant_name.focus();
                                 }else if(form.applicant_designation.value == "0"){
                                        alert("You must enter Proprietor's Designation");
                                        form.applicant_designation.focus();
                                 }/*else if(trim (form.money_receipt_no.value) == ""){
                                     alert("Enter Money Receipt Number");
                                     form.money_receipt_no.focus();
                                 }else if(form.money_receipt_date.value == "0000-00-00" || form.money_receipt_date.value ==""){
                                     alert("Enter valid Money Receipt date");
                                     form.money_receipt_date.focus();
                                 }*/else
                                   submitform( pressbutton );

                        }else if(document.adminForm.tabselection.value=="1"){
                                if(form.firm_reg_address_street.value == ""){
                                     alert("Please enter street/ area of the applicant's firm");
                                     form.firm_reg_address_street.focus();
                                 }else if(form.location.value == "0"){
                                     alert("You must select Location ");
                                     form.location.focus();
                                }else
                                   submitform( pressbutton );

                        }else if (document.adminForm.tabselection.value=="3"){
                                start =trim(form.trade_licence_issue_date.value);
                                  end   =trim(form.trade_licence_expire_date.value);

                                  start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                                  end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);

                                  if(trim(form.trade_licence_no.value) == ""){
                                           alert("Trade License No. cannot be blank");
                                           form.trade_licence_no.focus();
                                    }else if(trim(form.trade_licence_issued_by.value) == ""){
                                           alert("Authority of trade license cannot be blank");
                                           form.trade_licence_issued_by.focus();
                                    }else if(trim(form.trade_licence_issue_date.value) == ""){
                                           alert("Trade license issue date cannot be blank");
                                           form.trade_licence_issue_date.focus();
                                    }else if(trim(form.trade_licence_expire_date.value) == ""){
                                           alert("Trade license expiry date cannot be blank");
                                           form.trade_licence_expire_date.focus();
                                    }else if(start.getTime()>end.getTime() ){
                                           alert("Trade license issued date cannot be greater than expiry date");
                                           form.trade_licence_issued_by.focus();
                                    }else if(trim(form.tin.value) == ""){
                                           alert("Tax payers identification No. cannot be blank");
                                           form.tin.focus();
                                    }else{
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
                                                    <td  align="right" >
                                                    * Name of the Firm :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_name" value="<?php echo $_SESSION['firm_name']; ?>" size="54" maxlength="255"  />
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
                                <tr width=100%>
                                        <td  align="right">
                                        Established Year :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="establishment_year" value="<?php echo $_SESSION['establishment_year']; ?>" size="25" maxlength="4"  onKeyUp="javascript:check_IntNumber('establishment_year','Enter valid Establishment Year');" />
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
                                        <td height=24 align="center" colspan=2 valign=bottom>
                                        <b>Proprietor's Information</b>
                                        </td>
                                </tr>


                                <tr width=100%>
                                        <td  align="right">
                                        * Name of the Proprietor :
                                        </td>
                                        <td >
                                        <?php echo $lists['applicant_title'];?>
                                        &nbsp;&nbsp;First Name :
                                        <input class="text_area" type="text" name="applicant_name" value="<?php echo $_SESSION['applicant_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp;Last Name
                                        <input class="text_area" type="text" name="applicant_last_name" value="<?php echo $_SESSION['applicant_last_name']; ?>" size="25" maxlength="25"  />
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
                                                       <b>Applicant Firm Information</b>
                                                       </td>
                                               </tr>


                                           <tr width=100%>
                                                   <td  align="right" >
                                                   * Street / Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="firm_reg_address_street" value="<?php echo $_SESSION['firm_reg_address_street']; ?>" size="54" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana / Upazilla :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_town_suburb" value="<?php echo $_SESSION['firm_reg_address_town_suburb']; ?>" size="20" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   <input class="text_area" type="text" name="firm_reg_address_district" value="<?php echo $_SESSION['firm_reg_address_district']; ?>" size="21" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_division" value="<?php echo $_SESSION['firm_reg_address_division']; ?>" size="20" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   <input class="text_area" type="text" name="firm_reg_address_country" value="<?php echo $_SESSION['firm_reg_address_country']; ?>" size="21" maxlength="30"  />
                                                   </td>
                                           </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Phone :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $_SESSION['firm_phone']; ?>" size="20" maxlength="50"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                                    <input class="text_area" type="text" name="firm_fax" value="<?php echo $_SESSION['firm_fax']; ?>" size="21" maxlength="125"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                        <td  align="right">
                                        Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="firm_mobile" value="<?php echo $_SESSION['firm_mobile']; ?>" size="54" maxlength="35"  />
                                        </td>
                                </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Email address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_email" value="<?php echo $_SESSION['firm_email']; ?>" size="54" maxlength="125"  />
                                                    </td>
                                            </tr><tr width=100%>
                                                    <td  align="right">
                                                    Web address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_web" value="<?php echo $_SESSION['firm_web']; ?>" size="54" maxlength="125"  />
                                                    </td>
                                            </tr>
                                         <tr width=100%>
                                          <td height=26 align="center" colspan=2 valign=bottom>
                                           <input class="text_area" type="checkbox" name="check_firm_address" onClick="javascript:copy_firm_address();" />
                                           <b>Head Office/ Mailing Address</b>
                                          </td>
                                          </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Street / Area :
                                                   </td>
                                                   <td >
                                                   <input class="text_area" type="text" name="head_office_address_street" value="<?php echo $_SESSION['head_office_address_street']; ?>" size="54" maxlength="100"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana / Upazilla :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="head_office_address_town_suburb" value="<?php echo $_SESSION['head_office_address_town_suburb']; ?>" size="20" maxlength="30"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   <input class="text_area" type="text" name="head_office_address_district" value="<?php echo $_SESSION['head_office_address_district']; ?>" size="21" maxlength="30"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="head_office_address_division" value="<?php echo $_SESSION['head_office_address_division']; ?>" size="20" maxlength="20"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   <input class="text_area" type="text" name="head_office_address_country" value="<?php echo $_SESSION['head_office_address_country']; ?>" size="21" maxlength="30"  />
                                                   </td>
                                           </tr>
                                        <tr width=100%>
                                        <td  align="right">
                                        Phone :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_phone" value="<?php echo $_SESSION['head_office_phone']; ?>" size="20" maxlength="50"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                        <input class="text_area" type="text" name="head_office_fax" value="<?php echo $_SESSION['head_office_fax']; ?>" size="21" maxlength="125"  />
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td  align="right">
                                        Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_mobile" value="<?php echo $_SESSION['head_office_mobile']; ?>" size="54" maxlength="35"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Email address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_email" value="<?php echo $_SESSION['head_office_email']; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr><tr width=100%>
                                        <td  align="right">
                                        Web address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="head_office_web" value="<?php echo $_SESSION['head_office_web']; ?>" size="54" maxlength="125"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td height=10 align="right" colspan=2>&nbsp;
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
                                        Production Capacity / year :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="production_capacity" value="<?php echo $_SESSION['production_capacity']; ?>" size="25" maxlength="125" onKeyUp="javascript:check_IntNumber('production_capacity','Enter valid Production Capacity');" />

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
                                        * License Number :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_no" value="<?php echo $_SESSION['trade_licence_no']; ?>" size="20" maxlength="20"  />
                                        </td>
                                        <td  align="right">
                                        Importer Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="import_reg_no" value="<?php echo $_SESSION['import_reg_no']; ?>" size="28" maxlength="20"  />
                                        </td>


                                </tr>
                                <tr width=100%>
                                        <td align="right" width="25%">
                                        * Name of the Issuing Authority :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="<?php echo $_SESSION['trade_licence_issued_by']; ?>" size="20" maxlength="50"  />
                                        </td>
                                         <td  align="right">
                                        Exporter Reg. No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="export_reg_no" value="<?php echo $_SESSION['export_reg_no']; ?>" size="28" maxlength="20"  />
                                        </td>
                                </tr>
                                 <tr width=100%>
                                        <td align="right" width="25%">
                                        * Issue Date :
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
                                        * Expiry Date :
                                        </td>
                                        <td width="25%">
                                        <input class="text_area" type="text" name="trade_licence_expire_date" id="trade_licence_expire_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['trade_licence_expire_date']); ?>" size="20" maxlength="20" readonly />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                        <td  align="right">
                                        Registration Number under Factories Act :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="factory_act_reg_no" value="<?php echo $_SESSION['factory_act_reg_no']; ?>" size="28" maxlength="20"  />
                                        </td>


                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Tax Payers Identification number(TIN) :
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
                                        <th colspan="2">
                                         Details <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>
                                <tr width=100% >
                                <td valign="top" colspan=2 width=100% >
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr width=100%>
                                        <td  align="center" colspan=4>
                                        <b>Business Line Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" valign=top width=25%>
                                        Importer of :
                                        </td>
                                        <td width=25%>
                                        <?php echo $lists['product_line_impoter_of']; ?>
                                        </td>
                                        <td  align="right" valign=top width=25%>
                                        Importer of Country :
                                        </td>
                                        <td  width=25% align=left>
                                        <?php echo $lists['product_line_impoter_of_country']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" valign=top>
                                        Exporter of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_expoter_of']; ?>
                                        </td>

                                        <td  align="right" valign=top>
                                        Exporter of Country :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_expoter_of_country']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" valign=top>
                                        Traders of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_trader_of']; ?>
                                        </td>
                                        <td  align="right" valign=top>
                                        Dealers of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_dealer_of']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" valign=top>
                                        Manufacturers of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_manufacturer_of']; ?>
                                        </td>
                                        <td  align="right" valign=top>
                                        Indentors of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_indentor_of']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" valign=top>
                                        Assemblers/Processor of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_assembler_of']; ?>
                                        </td>
                                        <td  align="right" valign=top>
                                        Clearing and Forwarding Service Provider of :
                                        </td>
                                        <td >
                                        <?php echo $lists['product_line_service_provider_of']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  height=26 align="right" valign=middle colspan=2>
                                        Others of :
                                        </td>
                                        <td align=middle>
                                        <input class="text_area" type="text" name="product_line_others" value="<?php echo $_SESSION['product_line_others']; ?>" size="50" maxlength="255"  />
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
                <input type="hidden" name="option" value="com_non_member_ccci" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="step" value="1" />
                <input type="hidden" name="task" value="save" />
                <input type="hidden" name="hidemainmenu" value="0">
                </form>
                <script type="text/javascript">
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

                <?php
        }

}
?>
