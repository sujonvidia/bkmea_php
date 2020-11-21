<?php
/**
* @version $Id: admin.membership_certificate_scci.html.php,v 1.24 2006/07/16 11:28:56 morshed Exp $
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
class Membership_certificate_html {

        function PdfIcon( $row, $hide_js ) {
                global $mosConfig_live_site;
                        $working_reg_year_id=$_SESSION['working_reg_year_id'];
                        $user_id=$_SESSION['session_username'];
                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_certificate_scci&amp;do_pdf=1&amp;for=ccs&amp;id='. $row->id .'&amp;typeid='.$row->member_type_id.'&amp;user_id='.$user_id.'&amp;working_reg_year_id='.$working_reg_year_id;
                        $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );

                        ?>
                        <!--td align="right" width="100%" class="buttonheading"-->
                        <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
                        <?php echo "Certificate $image "; ?>
                        </a>
                        <!--/td-->
                        <?php
        }

        function CertificateOfficeCopyIcon( $row ) {
                global $mosConfig_live_site;
                        $working_reg_year_id=$_SESSION['working_reg_year_id'];
                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_certificate_scci&amp;do_pdf=1&amp;off=1&amp;for=ccs&amp;id='. $row->id.'&amp;working_reg_year_id='.$working_reg_year_id.'&amp;typeid='.$row->member_type_id;
                        $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
                ?>
                        <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
                        <?php echo "Office Copy $image "; ?>
                        </a>
                        <?php
        }


        function show( &$rows, &$pageNav,&$lists) {
                global $my, $mosConfig_live_site;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                <th class="categories">
                    Membership Certificate
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

                        $link = 'index2.php?option=com_membership_certificate_scci&task=editA&hidemainmenu=1&id='. $row->id;

                        $access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td >

                                 </td>

                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <!--td>
                                <?php echo $checked; ?>
                                </td-->
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
                                <?php echo stripslashes($row->member_type); ?>
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

                <input type="hidden" name="option" value="com_membership_certificate_scci" />
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
                global $mosConfig_absolute_path,$mosConfig_live_site,$my,$mosconfig_calender_date_format;

                $_SESSION['row']=$row;
                $_SESSION['printedtimes']=$printedtimes;

                if ($row->member_type_id==1)
                      $reg='G';
                else if ($row->member_type_id==2)
                      $reg='TA';
                else if ($row->member_type_id==3)
                      $reg='O';
                else if ($row->member_type_id==4)
                      $reg='A';

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
                        else if(form.printedtimes.value>0 && trim(form.money_receipt_no.value) == ""){
                            alert("You must enter money receipt no ");
                            form.money_receipt_no.focus();
                        }
                        else if(form.printedtimes.value>0 && form.money_receipt_date.value == ""){
                            alert("You must enter Money Receipt Date");
                            form.money_receipt_date.focus();
                        }
                        else if(form.bank.value == "0"){
                            alert("You must Select a Bank ");

                        }
                        else
                         submitform( pressbutton );
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">

                <table class="adminheading">

                <tr>
                        <th class="categories">

                         Membership certificate
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
                                         <table>
                                        <tr>
                                        <td width=91% align=center >
                                        <b>Member's Information</b>
                                        </td>
                                        <td  width=9% align=right>

                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                                <tr>
                                        <td width=15% ALIGN="right">
                                        Name of the Firm :
                                        </td>
                                        <td width=45%  >
                                          <?php echo stripslashes($row->firm);  ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td width=15% ALIGN="right">
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
                                        <td width=15% ALIGN="right">
                                        Address :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo stripslashes($address); ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td width=15% ALIGN="right">
                                        Current Membership Code :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->lastRegNO; ?>

                                        </td>
                                </tr>
                                <?php if(intval($printedtimes->printed_times)>0){ ?>
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
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0  class="calender_link"> (dd-mm-yyyy)
                                        <!--?php echo mosToolTip('This Date Formate is DD-MM-YYYY'); ?-->
                                        </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                        <td  ALIGN="right">
                                        * Bank :
                                        </td>
                                        <td >
                                       <?php echo $lists['bank']; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td width=15% ALIGN="right">
                                        Certificate Created in this Year :
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
                                        <td width=91% align=center >

                                        </td>
                                        <td  width=9% align=right>
                                        <?php Membership_certificate_html::CertificateOfficeCopyIcon($row); ?>
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

                <input type="hidden" name="option" value="com_membership_certificate_scci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="printedtimes" value="<?php echo intval($printedtimes->printed_times); ?>" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>

                 <script type="text/javascript">
                        if(document.adminForm.printedtimes.value>0){
                             Calendar.setup({
                             inputField     :    "money_receipt_date",      // id of the input field
                             ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                             showsTime      :    false,            // will display a time selector
                             button         :    "img1",   // trigger for the calendar (button ID)
                             singleClick    :    true,           // double-click mode
                             step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                             });
                        }


                </script>
                <?php
        }
      }
?>
