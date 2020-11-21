<?php
/**
* @version $Id: admin.membership_charge_bkmea.html.php,v 1.10 2006/04/30 10:07:00 morshed Exp $
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
class Membership_charge_html {

        /**
        * Writes a list of the categories for a section
        * @param array An array of category objects
        * @param string The name of the category section
        */
        function show( &$rows, &$pageNav) {
                global $my, $mosConfig_live_site;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                <th class="categories">
                    Charge Setup of Members
                </th>
                </tr>
                </table>

                <table class="adminlist">
                <tr>
                        <th width="10" align="left">
                        #
                        </th>
                        <th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th>
                        <th class="title" width=40%>
                        Member Type
                        </th>
                        <th class="title" width=30%>
                        Year
                        </th>
                        <th width="15%">
                        Enrollment fee
                        </th>
                        <th width="15%">
                        Renewal Fee
                        </th>
                        <!--th width="10%">
                        Published
                        </th>
                        <th colspan="2" width="5%">
                        Reorder
                        </th>
                        <th width="8%">
                        Order
                        </th>
                        <th width="1%">
                        <a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a>
                        </th>
                        <!--
                        <th width="10%">
                        Access
                        </th>
                        <th width="10%">
                            # Trash
                        </th-->
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_membership_charge_bkmea&task=editA&hidemainmenu=1&id='. $row->id;

                        $access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <td>
                                <?php echo $checked; ?>
                                </td>
                                <td>
                                <a href="<?php echo $link; ?>" class="underline">
                                <?php echo stripslashes($row->member_type_name) ; ?>
                                </a>
                                </td>
                                <td>
                                <?php echo $row->reg_year_name ; ?>
                                </td>
                                <td align="center">
                                <?php echo $row->enrollment_fee;?>
                                </td>
                                <td align="center">
                                <?php echo $row->renewal_fee;?>
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

                <input type="hidden" name="option" value="com_membership_charge_bkmea" />
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
        function edit( &$row, &$lists, $redirect, $menus ) {
                global $mosConfig_absolute_path;
                $calender_icon="$mosConfig_live_site/administrator/images/cal.gif";
                mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
                ?>
                <script language="javascript" type="text/javascript">
                var arr = new Array();
                   arr[27] = "0";
                   arr[28] = "1";
                   arr[29] = "2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_FloatNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.adminForm;
                   var msg=mid;
                   /*if(mid==1)
                     msg=msg1;
                   else
                     msg=msg2;*/
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
                              form.elements[obj].focus();;

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

                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        if(form.type_id.value == "0"){
                            alert("Please select member type");
                            form.type_id.focus();
                        }else if(form.member_reg_id.value == "0"){
                            alert("You must select registration year of member");
                            form.member_reg_id.focus();
                        }else if(form.enrollment_fee.value==""){
                            alert("Enter admission fee");
                            form.enrollment_fee.focus();
                        }else if(form.enrollment_development_fee.value==""){
                            alert("Enter Development Fee in Enrollment");
                            form.enrollment_development_fee.focus();
                        }else if(form.safety_measure_enrollment.value==""){
                            alert("Enter safety measure Fund");
                            form.safety_measure_enrollment.focus();
                        }else if(form.other_enrollment_fee.value==""){
                            alert("Enter other enrollment fee");
                            form.other_enrollment_fee.focus();
                        }else if(form.renew_development_fee.value==""){
                            alert("Enter Development Fee in Renewal Fees");
                            form.renew_development_fee.focus();
                        }else if(form.renew_development_fee.value==""){
                            alert("Enter Development Fee in Renewal Fees");
                            form.renew_development_fee.focus();
                        }else if(form.safety_measure_renewal.value==""){
                            alert("Enter safety measure Fund");
                            form.safety_measure_renewal.focus();
                        }else if(form.renewal_fee.value==""){
                            alert("Enter renewal fee");
                            form.renewal_fee.focus();
                        }else if(form.other_renewal_fee.value==""){
                            alert("Enter other renewal fee");
                            form.other_renewal_fee.focus();
                        }else {
                                submitform( pressbutton );
                        }
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Charge Setup of Members :
                        <small>
                        <?php echo $row->id ? 'Edit' : 'New';  ?>
                        </small>
                        </th>
                </tr>
                </table>

                <table width="100%" align=left>
                <tr>
                        <td valign="top" width="100%">
                                <table class="adminform">
                                <tr>
                                        <th colspan="3">
                                        Member charge details <small>( All fields are required ) </small>
                                        </th>
                                <tr>
                                <tr>
                                        <td align=right width=20%>
                                        * Member Type :
                                        </td>
                                        <td  width=80%>
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        * Year :
                                        </td>
                                        <td colspan="2">
                                        <?php echo $lists['member_reg_id']; ?>
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>

                                        </td>
                                        <td colspan="2">

                                        </td>
                                </tr>


                                <tr>
                                        <td align=right>
                                         <b>Enrollment Fees</b>
                                        </td>
                                        <td colspan="2">

                                        </td>
                                </tr>


                                <tr>
                                        <td align=right>
                                        * Admission  Fee :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="enrollment_fee"  value="<?php echo $row->enrollment_fee; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('enrollment_fee','Enter valid Admission fee');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Development  Fee :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="enrollment_development_fee"  value="<?php echo $row->enrollment_development_fee; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('enrollment_development_fee','Enter valid Development fee in Enrollment');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Safety  Measure Fund :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="safety_measure_enrollment"  value="<?php echo $row->safety_measure_enrollment; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('safety_measure_enrollment','Enter valid Safety Measure Fund');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Other Enrollment Fee :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="other_enrollment_fee"  value="<?php echo $row->other_enrollment_fee; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('other_enrollment_fee','Enter valid other Enrollment Fee');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>

                                        </td>
                                        <td colspan="2">

                                        </td>
                                </tr>


                                <tr>
                                        <td align=right>
                                         <b>Renewal Fees</b>
                                        </td>
                                        <td colspan="2">

                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Development Fee :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="renew_development_fee" value="<?php echo $row->renew_development_fee ; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('renew_development_fee','Enter valid Development Fee in Renewal Fees');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Safety Measure Fund :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="safety_measure_renewal" value="<?php echo $row->safety_measure_renewal; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('safety_measure_renewal','Enter Valid Safety Measure Fund');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Renewal Fee :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="renewal_fee" value="<?php echo $row->renewal_fee; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('renewal_fee','Enter Valid Renewal Fee');"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Other Renewal Fee :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="other_renewal_fee"  value="<?php echo $row->other_renewal_fee; ?>" size="25" maxlength="255"  onkeyup="javascript:check_FloatNumber('other_renewal_fee','Enter valid other Renewal Fee');"  />
                                        </td>
                                </tr>
                                </table>
                        </td>
                </tr>
                </table>

                <input type="hidden" name="option" value="com_membership_charge_bkmea" />
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }


        /**
        * Form to select Section to move Category to
        */
        function moveMembership_chargeSelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <br />
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Move Category
                        </th>
                </tr>
                </table>

                <br />
                <table class="adminform">
                <tr>
                        <td width="3%"></td>
                        <td align="left" valign="top" width="30%">
                        <strong>Move to Section:</strong>
                        <br />
                        <?php echo $SectionList ?>
                        <br /><br />
                        </td>
                        <td align="left" valign="top" width="20%">
                        <strong>Categories being moved:</strong>
                        <br />
                        <?php
                        echo "<ol>";
                        foreach ( $items as $item ) {
                                echo "<li>". $item->name ."</li>";
                        }
                        echo "</ol>";
                        ?>
                        </td>
                        <td valign="top" width="20%">
                        <strong>Content Items being moved:</strong>
                        <br />
                        <?php
                        echo "<ol>";
                        foreach ( $contents as $content ) {
                                echo "<li>". $content->title ."</li>";
                        }
                        echo "</ol>";
                        ?>
                        </td>
                        <td valign="top">
                        This will move the Categories listed
                        <br />
                        and all the items within the category (also listed)
                        <br />
                        to the selected Section.
                        </td>.
                </tr>
                </table>
                <br /><br />

                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
                <input type="hidden" name="boxchecked" value="1" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="task" value="" />
                <?php
                foreach ( $cid as $id ) {
                        echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
                }
                ?>
                </form>
                <?php
        }


        /**
        * Form to select Section to copy Category to
        */
        function copyMembership_chargeSelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <br />
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Copy Category
                        </th>
                </tr>
                </table>

                <br />
                <table class="adminform">
                <tr>
                        <td width="3%"></td>
                        <td align="left" valign="top" width="30%">
                        <strong>Copy to Section:</strong>
                        <br />
                        <?php echo $SectionList ?>
                        <br /><br />
                        </td>
                        <td align="left" valign="top" width="20%">
                        <strong>Categories being copied:</strong>
                        <br />
                        <?php
                        echo "<ol>";
                        foreach ( $items as $item ) {
                                echo "<li>". $item->name ."</li>";
                        }
                        echo "</ol>";
                        ?>
                        </td>
                        <td valign="top" width="20%">
                        <strong>Content Items being copied:</strong>
                        <br />
                        <?php
                        echo "<ol>";
                        foreach ( $contents as $content ) {
                                echo "<li>". $content->title ."</li>";
                                echo "\n <input type=\"hidden\" name=\"item[]\" value=\"$content->id\" />";
                        }
                        echo "</ol>";
                        ?>
                        </td>
                        <td valign="top">
                        This will copy the Categories listed
                        <br />
                        and all the items within the category (also listed)
                        <br />
                        to the selected Section.
                        </td>.
                </tr>
                </table>
                <br /><br />

                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
                <input type="hidden" name="boxchecked" value="1" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="task" value="" />
                <?php
                foreach ( $cid as $id ) {
                        echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
                }
                ?>
                </form>
                <?php
        }

}
?>
