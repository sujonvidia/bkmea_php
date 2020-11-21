<?php
/**
* @version $Id: admin.membership_certificate_bkmea.html.php,v 1.9 2006/03/19 06:14:07 morshed Exp $
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
                //if ( $params->get( 'pdf' ) && !$params->get( 'popup' ) && !$hide_js )
                {

                         $working_reg_year_id=$_SESSION['working_reg_year_id'];
                        $user_id=$_SESSION['session_username'];

                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_certificate_bkmea&amp;do_pdf=1&amp;id='. $row->id.'&amp;user_id='.$user_id.'&amp;working_reg_year_id='.$working_reg_year_id;
                        //if ( $params->get( 'icons' ) )
                        {
                                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
                        } /*else {
                       //         $image = _CMN_PDF .'&nbsp;';
                        }*/
                        ?>
                        <!--td align="right" width="100%" class="buttonheading"-->
                        <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
                        <?php echo "Certificate $image "; ?>
                        </a>
                        <!--/td-->
                        <?php
                }
        }


        function PdfIcon1( $row, $hide_js ) {
                global $mosConfig_live_site;
                //if ( $params->get( 'pdf' ) && !$params->get( 'popup' ) && !$hide_js )
                {
                         $working_reg_year_id=$_SESSION['working_reg_year_id'];
                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_certificate_bkmea&amp;do_pdf=1&amp;off=1&amp;id='.$row->id.'&amp;working_reg_year_id='.$working_reg_year_id;
                        //if ( $params->get( 'icons' ) )
                        {
                                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
                        } /*else {
                       //         $image = _CMN_PDF .'&nbsp;';
                        }*/
                        ?>
                        <!--td align="right" width="100%" class="buttonheading"-->
                        <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
                        <?php echo "Office Copy $image "; ?>
                        </a>
                        <!--/td-->
                        <?php
                }
        }




        function show( &$rows, &$pageNav, &$lists) {
                global $my, $mosConfig_live_site;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                            Member Certificate
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
                        <!--th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th-->
                        <th class="title" align=left width=15%>
                        Membership No.
                        </th>
                        <th class="title" align=left width=30%>
                        Firm Name
                        </th>

                        <th class="name" width=25% align=left>
                        Applicant Name
                        </th>

                        <th class="name" width=15% align=left>
                        Member Type
                        </th>
                         <th class="name" width=15% align=center>
                        Member Category
                        </th>

                        <!--th width="10%">
                        Published
                        </th-->
                        <!--th colspan="2" width="5%">
                            Reorder
                        </th-->
                        <!--th width="8%">
                        Order
                        </th-->
                        <!--th width="1%">
                        <a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a>
                        </th-->
                        <!--
                        <th width="10%">
                        Access
                        </th>     -->
                        <!--th width="10%">
                            # Active
                        </th-->
                        <!--th width="10%">
                            # Trash
                        </th-->
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_membership_certificate_bkmea&task=editA&hidemainmenu=1&id='. $row->id;

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
                                <td>
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

                                <td >
                                <?php echo stripslashes($row->member_type); ?>
                                </td>
                                <td align="center">
                                <?php echo stripslashes($row->member_category); ?>
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

                <input type="hidden" name="option" value="com_membership_certificate_bkmea" />
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
                global $mosConfig_absolute_path,$my;

                $_SESSION['row']=$row;


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
                              alert("Enter valid amount");
                              form.RenewFee.focus();
                              form.RenewFee.value="";
                          }
                           break;
                        }

                      }
                      if(j>37)
                      {
                        alert("Enter valid amount");
                        form.RenewFee.focus();
                        form.RenewFee.value="";
                        break;
                      }
                   }
                }



                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        //RenewFee

                        else if(form.RenewFee.value == ""){
                            alert("You must enter valid Renew fee ");
                            form.name.focus();
                        }
                        else if(form.money_receipt_no.value == ""){
                            alert("You must enter money receipt no ");
                            form.name.focus();
                        }




                      /*  if(form.title.value == ""){
                            alert("Please enter category title");
                            form.title.focus();
                        }else if(form.name.value == ""){
                            alert("You must enter category name");
                            form.name.focus();
                        }else {
                                submitform( pressbutton );
                        }*/// newly changed
                        submitform( pressbutton );
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">

                <table class="adminheading">

                <tr>
                        <th class="categories" width=60%>
                         Member Certificate
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
                                        <th colspan=2>
                                        <table>
                                        <tr>
                                        <td width=82%>
                                        <b>Member's Information</b>
                                        </td>
                                        <Td  width=18% align=right>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                                <tr>
                                        <td width=20% ALIGN="right">
                                        Name of the Firm:
                                        </td>
                                        <td width=80%  >
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
                                        <td ALIGN="right">
                                        Address :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <!--?php echo $row->applicant_address; ?-->
                                        <?php echo stripslashes($address) ?>

                                        </td>
                                </tr>


                                <tr>
                                        <td  ALIGN="right">
                                        Current Membership No :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->lastRegNO; ?>

                                        </td>
                                </tr>





                                 <tr>
                                        <td  ALIGN="right">
                                        Last Renewal year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->yearname; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td  ALIGN="right">
                                        Certificate Created in this Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $printedtimes->printed_times ? $printedtimes->printed_times : '0'; ?>

                                        </td>
                                </tr>

                                  <!--tr>
                                        <td  ALIGN="right">
                                        Voter :
                                        </td>
                                        <td >
                                       <?php echo $is_voter ? 'Voter' :' Not Voter' ; ?>

                                        </td>
                                </tr-->


                                <tr>
                                        <th colspan=2>
                                        <table>
                                        <tr>
                                        <td width=82%>

                                        </td>
                                        <Td  width=18% align=right>
                                        <?php

                                          if (($printedtimes->printed_times==0)||(($printedtimes->printed_times>0) && ($my->usertype=='Super Administrator')) )
                                          {
                                            Membership_certificate_html::PdfIcon( $row,$hide_js );
                                            echo "&nbsp;&nbsp;&nbsp;";
                                            Membership_certificate_html::PdfIcon1( $row,$hide_js );
                                          }
                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>



                                </table>
                                </center>
                        </td>
                </tr>

                </table>

                <input type="hidden" name="option" value="com_membership_certificate_bkmea" />
                <!--input type="hidden" name="id" value="<?php echo $row->id; ?>" /-->
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
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
