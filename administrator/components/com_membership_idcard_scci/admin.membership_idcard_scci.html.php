<?php
/**
* @version $Id: admin.membership_idcard_scci.html.php,v 1.24 2006/07/16 11:28:56 morshed Exp $
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
class Membership_idcard_html {



        function PdfIcon( $row, $hide_js ) {
                global $mosConfig_live_site;
                //if ( $params->get( 'pdf' ) && !$params->get( 'popup' ) && !$hide_js )
                {

                        $working_reg_year_id=$_SESSION['working_reg_year_id'];
                        $user_id=$_SESSION['session_username'];
                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_idcard_scci&amp;do_pdf=1&amp;preview=0&amp;id='. $row->id.'&amp;user_id='.$user_id.'&amp;working_reg_year_id='.$working_reg_year_id;
                        //if ( $params->get( 'icons' ) )
                        {
                                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
                        } /*else {
                       //         $image = _CMN_PDF .'&nbsp;';
                        }*/
                        ?>
                        <!--align="right" width="100%" class="buttonheading"-->
                        <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
                        <?php echo "ID Card $image "; ?>
                        </a>
                        <!--/td-->
                        <?php
                }
        }




        function IdCardPreviewIcon( $row ) {     // for office copy   at this moment we dont need here but in future we may need this
               global $mosConfig_live_site;
               $working_reg_year_id=$_SESSION['working_reg_year_id'];
               $user_id=$_SESSION['session_username'];
               $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
               //$link = $mosConfig_live_site. '/index2.php?option=com_membership_idcard_scci&amp;do_pdf=1&amp;preview=1&amp;off=1&amp;id='.$row->id;
               $link = $mosConfig_live_site. '/index2.php?option=com_membership_idcard_scci&amp;do_pdf=1&amp;id='. $row->id.'&amp;user_id='.$user_id.'&amp;working_reg_year_id='.$working_reg_year_id.'&amp;bank='.$bank.'&amp;money_receipt_no='.$money_receipt_no.'&amp;money_receipt_date='.$money_receipt_date.'&amp;preview=1';
               $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
               ?>
               <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
               <?php echo "Preview $image "; ?>
               </td>
               <?php
        }




        function show( &$rows, &$pageNav, &$lists) {
                global $my, $mosConfig_live_site;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                <th class="categories">
                    Member ID Card
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

                        <th width="3" align="left">

                        </th>

                        <th width="10" align="left">
                        #
                        </th>
                        <th class="name" width=20% align="left">
                        Membership Code
                        </th>
                        <th class="title" align=left width=35%>
                        Company Name
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

                        $link = 'index2.php?option=com_membership_idcard_scci&task=editA&hidemainmenu=1&id='. $row->id;

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
                                 <td align=left>
                                <?php echo $row->member_reg_no; ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" title="Edit Membership" class="underline">
                                <?php echo stripslashes($row->companyname); ?>
                                </a>
                                </td>

                                <td >
                                <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>
                                </td>



                                <td align="center">
                                <?php echo $row->member_type; ?>
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

                <input type="hidden" name="option" value="com_membership_idcard_scci" />
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

        function edit(&$row,  &$printedtimes, &$lists, $redirect, $menus ) {
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format, $my;

                $_SESSION['row']=$row;
                $_SESSION['printedtimes']=$printedtimes;

                ?>
                <script language="javascript" type="text/javascript">
                 var newWin;
                function newwindow_money_receipt(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                      page='../popup/moneyReceipt_popup.php?money_receipt_no='+document.adminForm.money_receipt_no.value+'&formName=adminForm';
                      newWin=window.open(page,'','width=425,height=130,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      newWin.focus();
               }
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(form.money_receipt_no.value == ""){
                            alert("You must enter money receipt No ");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == ""){
                            alert("You must enter Money Receipt Date");
                            form.money_receipt_date.focus();
                        }
                        else if(form.bank.value == "0"){
                            alert("You must select a Bank ");

                        }
                        else
                         submitform( pressbutton );
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">


                <table class="adminheading">

                <tr>
                        <th class="categories">
                         Membership ID Card
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
                                        <table>
                                        <tr>
                                        <td width=93% align=center>
                                        <b>Member's Information</b>
                                        </td>
                                        <td  width=7%>

                                        </td>
                                        </tr>
                                        </table>

                                        </th>
                                <tr>
                                <tr>
                                        <td width=15% ALIGN="right">
                                        Name of The Firm :
                                        </td>
                                        <td width=45%  >
                                          <?php echo stripslashes($row->firm); ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Applicant Name :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>

                                        </td>
                                </tr>

                                <?php
                                     $address=$row->street;
                                     $address.= trim($row->town)!="" ?", ".$row->town:"";
                                     $address.= trim($row->district)!="" ?", ".$row->district:"";
                                     $address.= trim($row->division)!="" ?", ".$row->division:"";
                                     $address.= trim($row->country)!="" ?", ".$row->country:"";
                                ?>
                                <tr>
                                        <td  ALIGN="right">
                                        Address :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $address; ?>

                                        </td>
                                </tr>


                                <tr>
                                        <td  ALIGN="right">
                                        Current Membershp Code :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->lastRegNO; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no" size="20" maxlength="15"  >
                                        &nbsp;<a href="javascript:newwindow_money_receipt();" style="text-decoration:underline;">Check Money Receipt Number</a>

                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        * Money Receipt Date :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date"  size="32" maxlength="255"  readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0  class="calender_link"> (DD-MM-YYYY)
                                        <!--?php echo mosToolTip('This Date Formate is DD-MM-YYYY'); ?-->
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
                                        ID Card Created in this Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo intval($printedtimes->printed_times); ?>

                                        </td>
                                </tr>
                                <tr>
                                        <th colspan="2">
                                        <table>
                                        <tr>
                                        <td width=93% align=center>

                                        </td>
                                        <td  width=7%>
                                        <div align=right> <?php Membership_idcard_html::IdCardPreviewIcon($row); ?></div>
                                        </td>
                                        </tr>
                                        </table>

                                        </th>
                                <tr>
                                 <!--tr>
                                        <td width=15% ALIGN="right" height=50>

                                        </td>
                                        <td >
                                        </td>
                                </tr-->
                                </table>
                                </center>
                        </td>
                </tr>

                </table>

                <input type="hidden" name="option" value="com_membership_idcard_scci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="printed_time" value="<?php echo intval($printedtimes->printed_times); ?>" />
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



                                  <tr>
                                        <td>
                                        Voter :
                                        </td>
                                        <td>
                                       <?php echo  $is_voter==1 ? 'Voter' : 'Not Voter' ; ?>
                                        </td>


                                </tr>





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
