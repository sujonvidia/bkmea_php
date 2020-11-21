<?php
/**
* @version $Id: admin.membership_edit_ccci.html.php,v 1.25 2006/12/21 11:53:21 morshed Exp $
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
                        <th class="firmname" width=30% align="left">
                        Firm Name
                        </th>
                        <th class="name" align="left" width=30%>
                        Applicant Name
                        </th>
                        <th class="name" align="left" width=20%>
                        Membership Code
                        </th>

                        <th class="type" align="left" with=25%>
                        Member Type
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
                                <?php echo stripslashes($row->applicant_name); ?>
                                </td>
                                <td>
                                <?php echo stripslashes($row->member_reg_no); ?>
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
        function editMembershipA( &$lists, $option, $id, $start_date, $end_date ,&$rows_importer,&$rows_exporter,&$rows_manufacturer,&$rows_trader,&$rows_dealer,&$rows_indentor,&$rows_assembler,&$rows_service_provider ) {
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
                 function belongs_to(){
                         var form = document.adminForm;
                         var belongsto=form.type_id.value;
                         /*
                        if (form.popup.value > 0){
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
                        if (belongsto==5){//|| (typeid==5)) {
                            document.getElementById('belongsto').style.display='inline';

                        }
                        else{
                            document.getElementById('belongsto').style.display='none';

                        }
                }


                function corporate(){
                        var form = document.adminForm;
                         var corporate1=form.corporate_status.value;
                          //alert("fdfg");
                        if (trim(corporate1)=="Limited Company"){
                            document.getElementById('memorandum_article').style.display='inline';
                            document.getElementById('partnership_deed').style.display='none';

                        }
                        else if (trim(corporate1)=="Partnership"){
                            document.getElementById('memorandum_article').style.display='none';
                            document.getElementById('partnership_deed').style.display='inline';

                        }
                        else{
                            document.getElementById('memorandum_article').style.display='none';
                            document.getElementById('partnership_deed').style.display='none';


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
                         newWin=window.open(page,'','width=450,height=150,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                         newWin.focus();

               }


                function submitbutton(pressbutton) {

                         //alert(document.adminForm.tabselection.value);

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
                        else if(document.adminForm.tabselection.value=="0")
                        {
                                if(form.type_id.value == "0"){
                                     alert("You must select Member Type ");
                                     form.type_id.focus();
                                }else if((form.type_id.value == "5") && (form.parent.value == "0")){
                                     alert("You must select Group/Town Associate");
                                     form.parent.focus();
                                }else if(form.last_reg_year_id.value == "0" ){
                                     alert("Registration Year cannot be blank");
                                     form.last_reg_year_id.focus();
                                } /* else if(form.member_reg_no.value == "" ){
                                     alert("Membership No can't be blank");
                                     form.member_reg_no.focus();
                                } */ else if(form.reg_date.value == "0000-00-00" || form.reg_date.value ==""){
                                     alert("Enter valid Registration date");
                                     form.reg_date.focus();
                                 }else if(reg.getTime()<start.getTime() || reg.getTime()>end.getTime()){
                                     alert("Registration date must be between "+form.start_date.value+" and "+form.end_date.value);
                                     form.reg_date.focus();
                                 }else if(form.firm_name.value == ""){
                                     alert("Firm's Name cannot be blank");
                                     form.firm_name.focus();
                                 }else if(form.corporate_status.value == "0"){
                                     alert("You must select Corporate status");
                                     form.corporate_status.focus();
                                 }else if((trim(form.corporate_status.value)=="Limited Company") && form.is_memorandum_article[1].checked == false){
                                     alert("Memorandum and Article of Association essential for Limited Company");
                                     form.is_memorandum_article[1].focus();
                                 }else if(trim(form.corporate_status.value)=="Partnership" && form.is_partnership_deed[1].checked == false){
                                     alert("You must select Prtnership Deed");
                                     form.is_partnership_deed[1].focus();
                                 }else if(trim (form.money_receipt_no.value) == ""){
                                           alert("Enter Money Receipt Number");
                                           form.money_receipt_no.focus();
                                 }else
                                   submitform( pressbutton );

                        }else if(document.adminForm.tabselection.value=="1"){
                         if(form.firm_reg_address_street.value == ""){
                            alert("Enter Firm's Street Address ");
                            form.firm_reg_address_street.focus();
                        }
                                else if (form.firm_email.value != "" && echeck(form.firm_email.value)==false){
                                     form.firm_email.focus();
                                }
                                else if (form.head_office_email.value != "" && echeck(form.head_office_email.value)==false){
                                     form.head_office_email.focus();
                                }
                                else if(form.location.value == "0"){
                                     alert("You must select Location ");
                                     form.location.focus();
                                }else
                                   submitform( pressbutton );

                        }else if(document.adminForm.tabselection.value=="3"){
                                    var img=form.up_file.value;
                                    var len=img.length;
                                    img=img.substr(len-3,3);
                                    var type_id="<?php echo $_SESSION['type_id']; ?>";


                                   if(type_id!=5 && form.applicant_name.value == ""){
                                       alert("The name of the proprietor cannot be blank");
                                       form.applicant_name.focus();
                                       }
                                    else if( type_id!=5 && form.applicant_designation.value == "0"){
                                        alert("You must enter the designation of the proprietor");
                                        form.applicant_designation.focus();
                                    }
                                    else if(type_id==5 && form.elements['up_file'].value != "" && img!="jpg"){
                                        alert("Enter valid image");
                                        form.elements['up_file'].focus();
                                    }/*else if(type_id==5 && form.representative_name.value == ""){
                                           alert("Representative name can't be blank");
                                           form.representative_name.focus();
                                    }else if(type_id==5 && form.representative_designation.value == 0){
                                         alert("You must select representative Designation");
                                         form.representative_designation.focus();
                                    }*/


                                 else
                                   submitform( pressbutton );

                        }else if (document.adminForm.tabselection.value=="4"){
                                  start =trim(form.trade_licence_issue_date.value);
                                  end   =trim(form.trade_licence_expire_date.value);

                                  start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                                  end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);

                                  
                                  if(trim(form.trade_licence_no.value) == ""){
                                           alert("Trade License No. cannot be blank");
                                           form.trade_licence_no.focus();
                                  }else if(trim(form.trade_licence_issued_by.value) == ""){
                                           alert("Authority of Trade License cannot be blank");
                                           form.trade_licence_issued_by.focus();
                                  }else if(trim(form.trade_licence_issue_date.value) == ""){
                                           alert("Trade License issue date cannot be blank");
                                           form.trade_licence_issue_date.focus();
                                  }else if(trim(form.trade_licence_expire_date.value) == ""){
                                           alert("Trade License expiry date cannot be blank");
                                           form.trade_licence_expire_date.focus();
                                  }else if(start.getTime()>end.getTime() ){
                                           alert("Treade license Issued date cannot be greater than Expiry date");
                                           form.trade_licence_issued_by.focus();
                                  }else 
                                  if(trim(form.tin.value) == ""){
                                           alert("Tax payers Identification No. cannot be blank");
                                           form.tin.focus();
                                  }else{
                                        submitform( pressbutton );
                                  }
                        }else if (document.adminForm.tabselection.value=="6"){
                                   /* if(trim(form.proposer_1_firm_name.value) == ""){
                                           alert("Enter the Proposer's Firm's Name");
                                           form.proposer_1_firm_name.focus();
                                    }else if (trim(form.proposer_2_firm_name .value) == ""){
                                           alert("Enter the Seconder's Firm's Name");
                                           form.proposer_2_firm_name .focus();
                                    }if(trim(form.proposer_1_name.value) == ""){
                                           alert("Enter the Proposer Name");
                                           form.proposer_1_name.focus();
                                    }else if (trim(form.proposer_2_name.value) == ""){
                                           alert("Enter the Seconder Name");
                                           form.proposer2_name.focus();
                                    }else{
                                                   submitform( pressbutton );
                                    }  */
                                     submitform( pressbutton );
                        }else if (document.adminForm.tabselection.value=="7"){
                                    if(trim(form.principal_nominee_name.value) == ""){
                                           alert("Enter the Principal Nominee's Name");
                                           form.principal_nominee_name.focus();
                                    }else if(trim(form.principal_nominee_designation.value) == "0"){
                                           alert("Enter the Principal Nominee's Designation");
                                           form.principal_nominee_designation.focus();
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
                <input type="hidden" name="popup" value="0">
                <input type="hidden" name="popup_type_id" value="0">
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
                                        <td  width="30%" align="right">
                                        * Member Type :
                                        </td>
                                        <td width="70%">
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                                </tr>

                                <tr width=100% id="belongsto" >
                                        <td  align="right" >
                                        * Belongs to :
                                        </td>
                                        <td >
                                        <?php echo $lists['parent']; ?>
                                        </td>
                                </tr>


                                  <script language='javascript'>belongs_to();</script>


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
                                        Member Registration No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no" value="<?php echo $_SESSION['member_reg_no']; ?>" size="30" maxlength="10"  onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid Membership Number');" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Registration Date :</div>
                                        </td>
                                        <td >

                                        <input readonly class="text_area" type="text" name="reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['reg_date']); ?>" size="20"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd-mm-yyyy'); ?>
                                        </td>
                                </tr>

                                            <tr width=100%>
                                                    <td  align="right" >
                                                    * Name of the Firm :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_name" value="<?php echo $_SESSION['firm_name']; ?>" size="50" maxlength="150"  />
                                                    </td>
                                  </tr>
                                   <tr width=100%>
                                        <td  align="right" >
                                         * Corporate Status :
                                        </td>
                                        <td >
                                        <?php
                                        echo $lists['corporate_status'];
                                        ?>
                                        </td>
                                </tr>
                                 <tr width=100% id="memorandum_article">
                                        <td  align="right">
                                        * Is Memorandum and Article of Association :
                                        </td>
                                        <td >
                                        <?php echo $lists['is_memorandum_article']; ?>
                                        </td>
                                </tr>
                                <tr width=100% id="partnership_deed">
                                        <td  align="right">
                                        * Is Partnership Deed :
                                        </td>
                                        <td >
                                        <?php echo $lists['is_partnership_deed']; ?>
                                        </td>
                                </tr>
                               <script language='javascript'>corporate();</script>

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
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" value="<?php echo $_SESSION['money_receipt_no']; ?>" size="50" maxlength="15"  />
                                        &nbsp;<a href="javascript:newwindow_money_receipt();" style="text-decoration:underline;">Check Money Receipt Number</a>
                                        </td>
                                </tr>


                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>* Money Receipt Date :</div>
                                        </td>
                                        <td >
                                        <input readonly class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo mosHTML::ConvertDateDisplayShort($_SESSION['money_receipt_date']); ?>" size="20"   />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img4" border=0 class="calender_link">
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
                                <tr width=100% >
                                        <td  align="right">
                                        Is Oustside City :
                                        </td>
                                        <td >
                                        <?php echo $lists['is_outside']; ?>
                                        </td>
                                </tr>

                           </table>
<?php
                $tabs->endTab();
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
                                                   <input class="text_area" type="text" name="firm_reg_address_street" value="<?php echo $_SESSION['firm_reg_address_street']; ?>" size="54" maxlength="100"  onkeypress="javascript:copy_firm_address(event);" />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Thana / Upazila :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_town_suburb" value="<?php echo $_SESSION['firm_reg_address_town_suburb']; ?>" size="20" maxlength="30"  onkeypress="javascript:copy_firm_address(event);"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;District :
                                                   <input class="text_area" type="text" name="firm_reg_address_district" value="<?php echo $_SESSION['firm_reg_address_district']; ?>" size="21" maxlength="30"  onkeypress="javascript:copy_firm_address(event);"  />
                                                   </td>
                                           </tr>
                                           <tr width=100%>
                                                   <td  align="right" >
                                                   Division :
                                                   </td>
                                                   <td  >
                                                   <input class="text_area" type="text" name="firm_reg_address_division" value="<?php echo $_SESSION['firm_reg_address_division']; ?>" size="20" maxlength="20"  onkeypress="javascript:copy_firm_address(event);"  />
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country :
                                                   <input class="text_area" type="text" name="firm_reg_address_country" value="<?php echo $_SESSION['firm_reg_address_country']; ?>" size="21" maxlength="30"  onkeypress="javascript:copy_firm_address(event);"  />
                                                   </td>
                                           </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Phone :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_phone" value="<?php echo $_SESSION['firm_phone']; ?>" size="20" maxlength="50"  onkeypress="javascript:copy_firm_address(event);"  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax :
                                                    <input class="text_area" type="text" name="firm_fax" value="<?php echo $_SESSION['firm_fax']; ?>" size="21" maxlength="125"  onkeypress="javascript:copy_firm_address(event);"  />
                                                    </td>
                                            </tr>
                                            <tr width=100%>
                                        <td  align="right">
                                        Mobile :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="firm_mobile" value="<?php echo $_SESSION['firm_mobile']; ?>" size="54" maxlength="35"  onkeypress="javascript:copy_firm_address(event);"  />
                                        </td>
                                </tr>
                                            <tr width=100%>
                                                    <td  align="right">
                                                    Email address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_email" value="<?php echo $_SESSION['firm_email']; ?>" size="54" maxlength="125"  onkeypress="javascript:copy_firm_address(event);"  />
                                                    </td>
                                            </tr><tr width=100%>
                                                    <td  align="right">
                                                    Web address :
                                                    </td>
                                                    <td >
                                                    <input class="text_area" type="text" name="firm_web" value="<?php echo $_SESSION['firm_web']; ?>" size="54" maxlength="125"  onkeypress="javascript:copy_firm_address(event);"  />
                                                    </td>
                                            </tr>
                                         <tr width=100%>
                                          <td height=26 align="center" colspan=2 valign=bottom>
                                           <input class="text_area" type="checkbox" name="check_firm_address" onClick="javascript:copy_firm_address('link');" />
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
                                                   Thana / Upazila :
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
                                        <td align=right >[ No of Employee ] Male :</td>
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
                                        <?php echo $lists['production_unit'];?>
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
$tabs->startTab("Representative","Representative-page");
?>
                            <table class="adminform">
                            <tr>
                            <td width=75%>
                            <table>
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
                                        <td  align="right">
                                        Photograph :
                                        </td>
                                        <td >
                                        <input class="text_area" type="file" name="up_file" size=25  />
                                        <?php echo mosToolTip('Image Format : .jpg '); ?>
                                        </td>
                                </tr>
                                </table>
                                </td>
                                <td width=25% valign=top align=left>
                                <table width=40% border=0 height=90>
                                <tr>
                                <td>
                                <?php
                                global $mosConfig_live_site;
                                //if(trim($_SESSION['applicant_photograph'])!="")
                                   $image_link="$mosConfig_live_site/administrator/images/photograph/$id/".$_SESSION['applicant_photograph'];
                                //else
                                //   $image_link="$mosConfig_live_site/administrator/images/photograph/not_available.jpg";
                                ?>
                                <img src='<?php echo $image_link; ?>' height='102' width='82' border=1>
                                </td>
                                </tr>
                                </table>
                                </td>
                                </tr>
                                <tr width=100%>
                                        <td height=10 align="center" colspan=2 valign=bottom>
                                        &nbsp;
                                        </td>
                                </tr>
                                 <?php if($_SESSION['type_id']==5){ ?>
                                <tr>
                                <td>
                                <table>
                                <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">

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
                                </table>
                                </td>
                                </tr>
                                 <?php } ?>
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
                                        <input class="text_area" type="text" name="trade_licence_no" value="<?php echo $_SESSION['trade_licence_no']; ?>" size="28" maxlength="20"  />
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
                                        <input class="text_area" type="text" name="trade_licence_issued_by" value="<?php echo $_SESSION['trade_licence_issued_by']; ?>" size="28" maxlength="50"  />
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
                                        <?php echo mosToolTip('Date Format : dd-mm-yyyy'); ?>
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
                                        <?php echo mosToolTip('Date Format : dd-mm-yyyy'); ?>
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
$tabs->endTab(); $tabs->startTab("Business Line","Businessline-page");
?>
                            <table class="adminform">
                             <tr>
                                        <th colspan="2">
                                         Details <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>
                                <tr width=100%>
                                <td valign="top" colspan=2 width=100%>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr width=100%>
                                        <td align="center" colspan="4">
                                        <b>Business Line Information</b> <br/>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  height="10" align="center"  colspan="4">

                                        &nbsp;
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  height="10" align="center" colspan="4">
                                        <b>Products:</b>
                                        </td>

                                </tr>
                                <tr width=100%>
                                        <td  height="5" align="center"  colspan="4">

                                        &nbsp;
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" valign="top" width="25%">
                                        Importer of :

                                        </td>
                                        <td align="left" valign="top" width="25%">
                                        &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,1,1);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_importer,$id,1,1,1);

                                        ?>
                                        </td>
                                        <td  align="right" valign="top" width="25%">
                                        Exporter of :
                                        </td>
                                        <td  align=left valign="top" width="25%">
                                         &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,2,1);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_exporter,$id,1,2,1);

                                        ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" valign="top">
                                        Manufacturer of :

                                        </td>
                                        <td align="left" valign="top">
                                        &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,3,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_manufacturer,$id,1,3,0);

                                        ?>
                                        </td>
                                        <td  align="right" valign="top">
                                        Trader of :
                                        </td>
                                        <td  align=left valign="top">
                                         &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,4,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_trader,$id,1,4,0);

                                        ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" valign="top">
                                        Dealer of :

                                        </td>
                                        <td align="left" valign="top">
                                        &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,5,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_dealer,$id,1,5,0);

                                        ?>
                                        </td>
                                        <td  align="right" valign="top">
                                        Indentor of :
                                        </td>
                                        <td  align=left valign="top">
                                         &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,6,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_indentor,$id,1,6,0);

                                        ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right" valign="top">
                                        Assemblers/Processor of :

                                        </td>
                                        <td align="left" valign="top">
                                        &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,1,7,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_assembler,$id,1,7,0);
                                        ?>
                                        </td>
                                        <td  align="right" valign="top">
                                        &nbsp;
                                        </td>
                                        <td  align="left" valign="top">
                                         &nbsp;

                                        &nbsp;
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  height="5" align="center" colspan="4">

                                        &nbsp;
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="center" colspan="4">
                                        <b>Services:</b>
                                        </td>

                                </tr>
                                <tr width=100%>
                                        <td  height="5" align="center" colspan="4">

                                        &nbsp;
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right" valign="top" colspan="2">
                                        Clearing and Forwarding Service Provider of :

                                        </td>
                                        <td align="left" valign="top" colspan="2">
                                        &nbsp;<a href="javascript:popupHSCode('new',<?php echo $id;?>,0,2,8,0);" style="text-decoration:none;"><b>Add New</b></a>
                                        <br>
                                        <?php
                                        HTML_Membership::businessLineInformation($rows_service_provider,$id,2,8,0);
                                        ?>
                                        </td>

                                </tr>

                                <!--tr width=100%>
                                        <td  height=26 align="right" valign=middle colspan=2>
                                        Others of :
                                        </td>
                                        <td align=left>
                                        <input class="text_area" type="text" name="product_line_others" value="<?php echo $_SESSION['product_line_others']; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr-->


                            </table>
                                </td>
                                </tr>

                            </table>
<?php
$tabs->endTab();
if($_SESSION['type_id']!=5){
$tabs->startTab("Proposer","Proposer");
?>
                            <table class="adminform">
                            <tr width=100%>
                                        <td  height=24 align="center" colspan=2 valign=bottom>
                                        <b>Proposer Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        Firm Name :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_1_firm_name" value="<?php echo $_SESSION['proposer_1_firm_name']; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                         Proposer Name :
                                        </td>
                                        <td >

                                        <?php echo $lists['proposer_1_title']; ?>


                                        &nbsp;&nbsp; First Name:
                                        <input class="text_area" type="text" name="proposer_1_name" value="<?php echo $_SESSION['proposer_1_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp;&nbsp;Last Name :
                                        <input class="text_area" type="text" name="proposer_1_last_name" value="<?php echo $_SESSION['proposer_1_last_name']; ?>" size="25" maxlength="25"  />
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
                                 <!--tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Proposer' onclick=javascript:newwindow(1); />
                                                        </td>
                                 </tr-->
                                <!--tr width=100%>
                                        <td width=30% align="right">
                                        * Membership No. :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_1_member_reg_no" value="<?php echo $_SESSION['proposer_1_member_reg_no']; ?>" size="50" maxlength="20"  />
                                        </td>
                                </tr-->

                                <tr width =100% hight=30>
                                </tr>
                                <tr width=100%>
                                        <td height="25" align="center" colspan="2" valign="bottom">

                                        &nbsp;<b>Seconder Information</b>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td width=30% align="right">
                                        Firm Name :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_2_firm_name" value="<?php echo $_SESSION['proposer_2_firm_name']; ?>" size="50" maxlength="100"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                         Seconder Name :
                                        </td>
                                        <td >
                                        <?php echo $lists['proposer_2_title']; ?>
                                        &nbsp;&nbsp; First Name :
                                        <input class="text_area" type="text" name="proposer_2_name" value="<?php echo $_SESSION['proposer_2_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp;Last Name :
                                        <input class="text_area" type="text" name="proposer_2_last_name" value="<?php echo $_SESSION['proposer_2_last_name']; ?>" size="25" maxlength="25"  />
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

                                 <!--tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        <input type='button' name='Validity' class='button' size='40'  value='Find Seconder' onclick=javascript:newwindow(2); />
                                                        </td>
                                 </tr-->
                                <!--tr width=100%>
                                        <td width=30% align="right">
                                        * Membership No. :
                                        </td>
                                        <td width=70%>
                                        <input class="text_area" type="text" name="proposer_2_member_reg_no" value="<?php echo $_SESSION['proposer2_member_reg_no']; ?>" size="50" maxlength="20"  />
                                        </td>
                                </tr-->

                            </table>
<?php
$tabs->endTab();

        $tabs->startTab("Nominees","Nominees-page");
?>
                            <table class="adminform">
                             <tr width=100%>
                                        <td height=5 align="center" colspan=2 valign=bottom>
                                        &nbsp;
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Name of the Principal Nominee :
                                        </td>
                                        <td >
                                        <?php echo $lists['principal_nominee_title']; ?>
                                        &nbsp;&nbsp; First Name :
                                        <input class="text_area" type="text" name="principal_nominee_name" value="<?php echo $_SESSION['principal_nominee_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp; Last Name :
                                        <input class="text_area" type="text" name="principal_nominee_last_name" value="<?php echo $_SESSION['principal_nominee_last_name']; ?>" size="25" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        * Designation :
                                        </td>
                                        <td >
                                        <?php echo $lists['principal_nominee_designation']; ?>
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td height=5 align="center" colspan=2 valign=bottom>
                                        &nbsp;
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Alternative Nominee Name :
                                        </td>
                                        <td >
                                        <?php echo $lists['alt_nominee_title']; ?>&nbsp;&nbsp; First Name :
                                        <input class="text_area" type="text" name="alt_nominee_name" value="<?php echo $_SESSION['alt_nominee_name']; ?>" size="25" maxlength="25"  />
                                        &nbsp;&nbsp; Last Name :
                                        <input class="text_area" type="text" name="alt_nominee_last_name" value="<?php echo $_SESSION['alt_nominee_last_name']; ?>" size="25" maxlength="25"  />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        Designation :
                                        </td>
                                        <td >
                                        <?php echo $lists['alt_nominee_designation']; ?>
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
                <input type="hidden" name="option" value="com_membership_edit_ccci" />
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

                <?php
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
                         echo $sl.". ".$row->name."&nbsp;&nbsp;".$countryList."&nbsp;&nbsp;<a href=\"javascript:popupHSCode('edit',$member_id,$row->id,$hscodeType,$businessType,$countryId);\" style=\"text-decoration:none;\"><b>Edit</b></a>"."/&nbsp;<a href=\"index2.php?option=com_membership_edit_ccci&task=dbli&member_id=$member_id&product_id=$row->id&businessType=$businessType&member_product_id=$row->member_product_id\" style=\"text-decoration:none;\"><b>Delete</b></a>"."<br>";
                         $sl++;
                      }
        }

}
?>
