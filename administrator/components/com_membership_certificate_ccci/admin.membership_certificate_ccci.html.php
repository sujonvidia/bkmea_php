<?php
/**
* @version $Id: admin.membership_certificate_ccci.html.php,v 1.13 2006/03/09 06:36:00 nnabi Exp $
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
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_certificate_ccci&amp;do_pdf=1&amp;for=ccc&amp;id='. $row->id.'&amp;user_id='.$user_id.'&amp;working_reg_year_id='.$working_reg_year_id;
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


        function PdfIcon1( $row, $hide_js ) {     // for office copy
                global $mosConfig_live_site;
                //if ( $params->get( 'pdf' ) && !$params->get( 'popup' ) && !$hide_js )
                {
                        $working_reg_year_id=$_SESSION['working_reg_year_id'];
                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_certificate_ccci&amp;do_pdf=1&amp;for=ccc&amp;off=1&amp;id='. $row->id.'&amp;working_reg_year_id='.$working_reg_year_id;
                        //if ( $params->get( 'icons' ) ){
                                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
                        /* } else {
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
                <tr>
                        <th width="3" align="left">

                        </th>

                        <th width="10" align="left">
                        #
                        </th>
                        <!--th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th-->
                        <th class="title" align=left width=35%>
                        Firm Name
                        </th>

                        <th class="name" width=30% align=left>
                        Applicant/ Representative Name
                        </th>



                        <th class="name" width=20% align=left>
                        Member Type
                        </th>

                         <th class="name" width=15% align=center>
                        Membership No
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

                        $link = 'index2.php?option=com_membership_certificate_ccci&task=editA&hidemainmenu=1&id='. $row->id;

                        //$access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">

                                <td>

                               </td>

                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <!--td>
                                <?php echo $checked; ?>
                                </td-->
                                <td>
                                <a href="<?php echo $link; ?>" title="Edit Membership">
                                <?php echo stripslashes($row->companyname); ?>
                                </a>
                                </td>

                                  <td >
                                <?php
                                if($row->type==3 || $row->type==4 || $row->type==5)
                                   echo stripslashes($row->a_title." ".$row->a_first_name."".$row->a_last_name);
                                else
                                   echo stripslashes($row->r_title." ".$row->r_first_name."".$row->r_last_name);
                                ?>
                                </td>



                                <td >
                                <?php echo $row->member_type;?>
                                </td>

                                <td align="center">
                                <?php echo $row->member_reg_no; ?>
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

                <input type="hidden" name="option" value="com_membership_certificate_ccci" />
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
                            alert("You must enter valid Renewal fee ");
                            form.name.focus();
                        }
                        else if(form.money_receipt_no.value == ""){
                            alert("You must enter money receipt No. ");
                            form.name.focus();
                        }
                        submitform( pressbutton );
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">


                <table class="adminheading" >

                <tr>
                        <th class="categories" width=60%>
                        Membership Certificate
                        <!--small>
                        <?php echo $history->historyid ? 'Edit' : 'New';  ?>
                        </small-->


                        </th>
                </tr>

                </table>

                <table width="100%" >

                <tr>
                        <td valign="top" width="100%" >
                        <center>
                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        <b>Member's Information</b>
                                       </th>
                                <tr>
                                <tr>
                                        <td width=30% ALIGN="right">
                                        Name of the Firm :
                                        </td>
                                        <td width=70%  >
                                          <?php echo stripslashes($row->firm); ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td ALIGN="right">
                                        Name of the Applicant :
                                        </td>
                                        <td >
                                        <?php

                                          if($row->member_type_id==3 || $row->member_type_id==4 || $row->member_type_id==5)
                                             echo stripslashes($row->a_title." ".$row->a_first_name."".$row->a_last_name);
                                          else
                                             echo stripslashes($row->r_title." ".$row->r_first_name."".$row->r_last_name);

                                        ?>

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
                                        <?php echo stripslashes($address); ?>

                                        </td>
                                </tr>


                                <tr>
                                        <td ALIGN="right">
                                        Current Membership No :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->lastRegNO; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td ALIGN="right">
                                        Certificate Created in this Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $printedtimes->printed_times ? $printedtimes->printed_times : '0'; ?>

                                        </td>
                                </tr>
                                <tr>

                                        <th colspan="2" align="right">
                                        <?php
                                        if (($printedtimes->printed_times==0)||(($printedtimes->printed_times>0) && ($my->usertype=='Super Administrator')) )
                                        {
                                            Membership_certificate_html::PdfIcon( $row,$hide_js );
                                            echo "&nbsp;&nbsp;&nbsp;";
                                            Membership_certificate_html::PdfIcon1( $row,$hide_js );
                                        }
                                        ?>
                                        </th>
                                </tr>
                                <!--tr>
                                        <td ALIGN="right" height=200>
                                        </td>
                                        <td >
                                        </td>
                                </tr-->
                                </table>
                                </center>
                        </td>
                </tr>

                </table>

                <input type="hidden" name="option" value="com_membership_certificate_ccci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }



}
?>
