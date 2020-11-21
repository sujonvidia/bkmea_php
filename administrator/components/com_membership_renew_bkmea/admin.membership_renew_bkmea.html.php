<?php
/**
* @version $Id: admin.membership_renew_bkmea.html.php,v 1.17 2006/07/31 07:31:07 morshed Exp $
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
                        <input type="text" name="search" value="<?php echo stripslashes($search);?>" class="text_area" onChange="document.adminForm.submit();" />
                        </td>
                        <td width="right">
                        <?php echo $lists['search_type_id']; ?>
                        </td>
                </tr>
                </table>


                <table class="adminlist">
                <tr>
                         <th width="3" align="left">

                        </th>

                        <th width="10" align="left">
                        #
                        </th>
                        <!--th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th-->
                        <th class="title" align=left width=20%>
                        Membership No.
                        </th>
                        <th class="title" align=left width=25%>
                        Firm Name
                        </th>

                        <th class="name" width=20% align=left>
                        Applicant Name
                        </th>

                        <th class="name" width=20% align=left>
                        Member Type
                        </th>

                        <th class="name" width=15% align=left>
                        Last Renewal Year
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_membership_renew_bkmea&task=editA&hidemainmenu=1&id='. $row->id;

                        $access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">

                                <td width="3" align="left">

                                </td>

                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <!--td>
                                <?php echo $checked; ?>
                                </td-->
                                <td >
                                <?php echo stripslashes($row->member_reg_no); ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" title="Edit Membership" class="underline">
                                <?php echo stripslashes($row->companyname); ?>
                                </a>
                                </td>

                                <td >
                                <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>
                                </td>

                                <td >
                                <?php echo stripslashes($row->member_type); ?>
                                </td>


                                <td >
                                <?php echo $row->yearname; ?>
                                </td>

                                <!--td align="center">
                                <?php echo $published;?>
                                </td-->
                                <!--td>
                                <?php echo $pageNav->orderUpIcon( $i ); ?>
                                </td-->
                                <!--td>
                                <?php echo $pageNav->orderDownIcon( $i, $n ); ?>
                                </td-->
                                <!--td align="center" colspan="2">
                                <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
                                </td-->
                                <!--td align="center">
                                <?php echo $row->active; ?>
                                </td-->
                                <!--td align="center">
                                <?php echo $row->trash; ?>
                                </td-->
                                <?php

                                $k = 1 - $k;
                                ?>
                        </tr>
                        <?php
                }
                ?>
                </table>

                <?php echo $pageNav->getListFooter(); ?>

                <input type="hidden" name="option" value="com_membership_renew_bkmea" />
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

        function edit(&$history, &$cur_reg_year, &$renew, &$row, &$lists, $redirect, $start_date, $end_date,&$enrolmentyear ) {
                global $mosConfig_absolute_path,$mosConfig_live_site,$mosconfig_calender_date_format;

                $_SESSION['row']=$row;
                $_SESSION['cur_reg_year']=$cur_reg_year;
                $_SESSION['renew']=$renew;
                $_SESSION['history']=$history;




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

                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var start, end, reg;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        ren   =trim(form.renew_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        ren=new Date(ren.split('-')[2],ren.split('-')[1],ren.split('-')[0]);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(form.money_receipt_no.value == ""){
                            alert("You Must Enter Money Receipt No.");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == ""){
                            alert("You Must Enter Money Receipt Date");
                            form.money_receipt_date.focus();
                        }
                        else if(form.RenewFee.value == ""){
                            alert("You Must Enter Renewal fee ");
                            form.RenewFee.focus();
                        } else if(trim(form.renew_date.value) == ""){
                            alert("You Must Enter Renewal Date");
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
                        <small>
                        <?php echo $history->historyid ? '' : '';  ?>
                        </small>

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
                                        Membership Renewal Informartion <small>( Fields marked with an asterisk * are required )</small>
                                        </th>

                                <tr>
                                <?php $link = 'index2.php?option=com_membership_edit_bkmea&task=editA&hidemainmenu=1&id='. $row->id;
                                ?>
                                <tr>
                                        <td width=20% ALIGN="right">
                                        Name of the Firm :
                                        </td>
                                        <td width=80%  >
                                        <a href="<?php echo $link; ?>" title="Edit Membership" class="underline" >
                                          <?php echo stripslashes($row->firm); ?>
                                         </a>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Name of the Applicant :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td  ALIGN="right">
                                        Current Membership No :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo stripslashes($row->lastRegNO); ?>

                                        </td>
                                </tr>
                                 <tr>
                                        <td ALIGN="right">
                                        Enrollment Year :
                                 </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $enrolmentyear->enrolmentyear; ?>

                                        </td>
                                </tr>



                                 <tr>
                                        <td ALIGN="right">
                                        Last Enrollment/Renewal Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->yeartitle; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Renewal for Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $cur_reg_year->curr_reg_year; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        * Money Receipt No. :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="money_receipt_no"  value="<?php echo $historyid->historyid ? $history->money_receipt_no : ''; ?>"  size="20" maxlength="15"  -->
                                        <input class="text_area" type="text" name="money_receipt_no"  size="20" maxlength="15"  >
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        * Money Receipt Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" size="20" maxlength="255"  readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php echo mosToolTip('This Date Formate is DD-MM-YYYY'); ?>
                                        </td>
                                </tr>
                                 <tr>
                                        <td  ALIGN="right">
                                        * Renewal Fee :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="RenewFee" onkeyup=javascript:check_cn1(); value="<?php echo $renew->renewal_fee; ?>" size="20" maxlength="6"  readonly>
                                        <?php echo mosToolTip('This fee is calculated from the last renewal fee'); ?>
                                        </td>
                                </tr>
                                  <!--tr>
                                        <td ALIGN="right">
                                        Voter :
                                        </td>
                                        <td >
                                       <?php echo $lists['is_voter']; ?>

                                        </td>
                                </tr-->
                                <tr>
                                        <td align=right>
                                        * Renewal Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="renew_date" id="renew_date" size="20" maxlength="255"  readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        <?php echo mosToolTip('This Date Formate is DD-MM-YYYY'); ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Any Investment In Last 1 Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="money_receipt_no"  value="<?php echo $historyid->historyid ? $history->money_receipt_no : ''; ?>"  size="20" maxlength="15"  -->
                                        <input class="text_area" type="text" name="investment"  size="20" maxlength="15"  >
                                        </td>
                                </tr>


                                </table>
                                </center>
                        </td>
                </tr>

                </table>

                <input type="hidden" name="option" value="com_membership_renew_bkmea" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="type_id" value="<?php echo $row->type_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "renew_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
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
                        Membership Renewal
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
                        <td valign="top" width="100%">

                                <table class="adminform">
                                <tr>
                                        <th colspan="2" align=left>
                                        Membership Renewal Information
                                        </th>
                                <tr>
                                <tr>
                                        <td width=30% >
                                        Name of the firm
                                        </td>
                                        <td width=70%>
                                          <?php echo $row1->firm; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td>
                                        Name of the Applicant  :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td>
                                        Current Membership No. :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row1->lastRegNO; ?>

                                        </td>
                                </tr>


                                 <tr>
                                        <td>
                                        Last Renewal year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row1->yeartitle; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td>
                                        Renewal for Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $cur_reg_year1->curr_reg_year; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td>
                                        Money Receipt No. :
                                        </td>
                                        <td >
                                        <?php echo $money_receipt_no; ?>

                                        </td>
                                </tr>

                                 <tr>
                                        <td>
                                        * Renewal Fee :
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


                <input type="hidden" name="option" value="com_membership_renew_bkmea" />
                <!--input type="hidden" name="id" value="<?php echo $row->id; ?>" /-->
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

}
?>
