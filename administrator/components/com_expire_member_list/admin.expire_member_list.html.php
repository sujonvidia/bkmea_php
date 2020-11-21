<?php
/**
* @version $Id: admin.expire_member_list.html.php,v 1.5 2006/04/02 06:23:24 morshed Exp $
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
class ExpireMember_html {

        /**
        * Writes a list of the categories for a section
        * @param array An array of category objects
        * @param string The name of the category section
        */
         function show( &$rows, &$pageNav, &$lists) {
                global $my, $mosConfig_live_site, $mosConfig_owner;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Expired Membership List
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
                        <th width="2" align="left">

                        </th>
                        <th width="10" align="left">
                        #
                        </th>
                        <th class="title" align=left width=15%>
                        <?php
                        if(strtolower($mosConfig_owner)=="ccci")
                          echo "Membership No.";
                        else if(strtolower($mosConfig_owner)=="scci")
                          echo "Membership Code";
                        ?>

                        </th>
                        <th class="title" align=left width=35%>
                        Firm Name
                        </th>
                        <th class="name" width=35% align=left>
                        Applicant/ Representative Name
                        </th>
                        <th class="name" width=15% align=left>
                        Member Type
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_expire_member_list&task=editA&hidemainmenu=1&id='. $row->id;

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
                                <td align="left">
                                <?php echo $row->member_reg_no; ?>
                                <td>
                                <a href="<?php echo $link; ?>" class="underline">
                                <?php echo stripslashes($row->companyname); ?>
                                </a>
                                </td>
                                <td >
                                        <?php
                                        if($row->mtype!=1 && $row->mtype!=2)
                                           echo stripslashes($row->title)." ".stripslashes($row->first_name)." ".stripslashes($row->last_name);
                                        else
                                            echo stripslashes($row->rtitle)." ".stripslashes($row->rfirst_name)." ".stripslashes($row->rlast_name);
                                        ?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->member_type);?>
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

                <input type="hidden" name="option" value="com_expire_member_list" />
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


        function edit( &$row, $start_date, $end_date, &$lists ) {
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format, $mosConfig_owner;
                global $database;


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
                }

                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var start, end, reg, owner;
                        owner="<?php echo strtolower($mosConfig_owner); ?>";
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        reg   =trim(form.enrollment_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        else if(owner=="scci" && (form.member_reg_no.value == "" || form.member_reg_no.value == 0)){
                            alert("Please enter valid membership number");
                            form.member_reg_no.focus();
                        }
                        else if(owner=="scci" && form.bank.value == "0"){
                            alert("You must select a Bank ");
                            form.bank.focus();
                        }
                        else if(form.money_receipt_no.value == ""){
                            alert("You must enter Money Receipt No");
                            form.money_receipt_no.focus();
                        }
                        else if(form.money_receipt_date.value == ""){
                            alert("You must enter Money Receipt Date");
                            form.money_receipt_date.focus();
                        }
                        else if(form.enrollment_date.value==""){
                            alert("You must enter Enrollment Date");
                        }
                        else if(reg.getTime()<start.getTime() || reg.getTime()>end.getTime()){
                            alert("Enrollment Date must be between "+form.start_date.value+" and "+form.end_date.value);
                        }
                        else{
                                var con=0;
                                con =confirm("Are you sure ? ");

                                if (con==1)
                                {
                                  submitform( pressbutton );
                                }
                                else
                                   return;
                        }

                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                   <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                <table class="adminheading">

                <tr>
                        <th class="categories">
                        Expired Member : Enrollment
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
                                        Member's  Information <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                <tr>
                                <tr>
                                        <td width=30% ALIGN="right">
                                        Name of the Firm :
                                        </td>
                                        <td width=70%  >
                                          <?php echo stripslashes($row->firm_name); ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Name of the Applicant/ Representative :
                                        </td>
                                        <td >
                                        <?php
                                        if($row->mtype!=1 && $row->mtype!=2)
                                           echo stripslashes($row->title)." ".stripslashes($row->first_name)." ".stripslashes($row->last_name);
                                        else
                                            echo stripslashes($row->rtitle)." ".stripslashes($row->rfirst_name)." ".stripslashes($row->rlast_name);
                                        ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Member Type :
                                        </td>
                                        <td >
                                        <?php echo $row->member_type; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Last Enrollment/ Renewal Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $row->last_reg_year_name; ?>

                                        </td>
                                </tr>
                                <tr>
                                        <td  ALIGN="right">
                                        Enrollment For Year :
                                        </td>
                                        <td >
                                        <!--input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  /-->
                                        <?php echo $_SESSION['working_reg_year_name']; ?>

                                        </td>
                                </tr>

                                <tr>
                                        <td ALIGN="right">
                                          <?php
                                          if(strtolower($mosConfig_owner)=="ccci"){
                                            echo "* Membership No. : ";
                                            $readonly="";
                                          }
                                          else if(strtolower($mosConfig_owner)=="scci") {
                                            echo "* Membership Code : ";
                                            $readonly="readonly=true";
                                          }
                                          ?>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="member_reg_no"  size="20" maxlength="20"  value="<?php echo $row->member_reg_no; ?>" <?php echo $readonly; ?> onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid Membership Number');" />
                                        </td>
                                </tr>

                            <?php
                            if(strtolower($mosConfig_owner)=="ccci") {
                            }
                            else if(strtolower($mosConfig_owner)=="scci"){
                            ?>
                                <tr>
                                        <td  ALIGN="right">
                                        * Bank :
                                        </td>
                                        <td >
                                       <?php echo $lists['bank']; ?>

                                        </td>
                                </tr>
                            <?php } ?>
                                <tr>
                                        <td  ALIGN="right">
                                        * Money Receipt No :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="money_receipt_no"  size="20" maxlength="15"  >
                                        </td>
                                </tr>
                               <tr>
                                        <td align=right>
                                        * Money Receipt Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="" size="20" maxlength="255"  readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0  class="calender_link">
                                        <?php echo mosToolTip('This Date Formate is DD-MM-YYYY'); ?>
                                        </td>
                                </tr>
                                 <tr>
                                        <td ALIGN="right">
                                        * Enrollment Fee :
                                        </td>
                                        <td >
                                        <input class="text_area"  type="text" name="enrollment_fee"  value="<?php echo $row->enrollment_fee ; ?>" readonly=true size="20" maxlength="255"  >
                                        <?php echo mosToolTip('This is the Enrollment fee of this year'); ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        * Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="enrollment_date" id="enrollment_date" value="" size="20" maxlength="255"  readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0  class="calender_link">
                                        <?php echo mosToolTip('This Date Formate is DD-MM-YYYY'); ?>
                                        </td>
                                 </tr>
                                </table>
                                </center>
                        </td>
                </tr>

                </table>

                <input type="hidden" name="option" value="com_expire_member_list" />
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="type_id" value="<?php echo $row->member_type_id; ?>" />
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>

                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "enrollment_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>

                <?php
        }

}
?>
