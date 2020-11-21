<?php
/**
* @version $Id: admin.member_reg_year_bkmea.html.php,v 1.8 2006/03/07 07:47:22 sami Exp $
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
class Member_reg_year_html {

        /**
        * Writes a list of the categories for a section
        * @param array An array of category objects
        * @param string The name of the category section
        */
        function show( &$rows, &$pageNav) {
                global $my, $mosConfig_live_site, $mosconfig_show_date_format;

                mosCommonHTML::loadOverlib();
                ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                <th class="categories">
                    Registration Year of Members
                </th>
                <td width="right">
                  <?php
                     //section list
                    //echo $lists['sectionid'];
                  ?>
                </td>
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
                        <th class="title" width=50%>
                        Name
                        </th>
                        <th class="title" width=25%>
                        Start Date
                        </th>
                        <th class="title" width=25%>
                        End Date
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_member_reg_year_bkmea&task=editA&hidemainmenu=1&id='. $row->id;

                        //$access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
                        //$published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <td>
                                <?php echo $checked; ?>
                                </td>
                                <td>
                                <?php
                                if ( $row->checked_out_contact_category && ( $row->checked_out_contact_category != $my->id ) ) {
                                        echo $row->name;
                                } else {
                                        ?>
                                        <a href="<?php echo $link; ?>" class="underline">
                                        <?php echo stripslashes($row->name); ?>
                                        </a>
                                        <?php
                                }
                                ?>
                                </td>
                                <td align="left">
                                <?php echo mosHTML::ConvertDateDisplayLong($row->start_date); ?>
                                </td>
                                <td align="left">
                                <?php echo mosHTML::ConvertDateDisplayLong($row->end_date);
                                ?>
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

                <input type="hidden" name="option" value="com_member_reg_year_bkmea" />
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
        function edit( &$row, &$lists, $redirect, $menus, $prev_end_date ) {
                global $mosConfig_live_site, $mosconfig_calender_date_format;
                mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
                ?>
                <script language="javascript" type="text/javascript">
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var old_sdate, new_sdate, new_edate;

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        old_edate=trim(form.prev_end_date.value);
                        var chk = old_edate;
                        old_edate=new Date(old_edate.split('-')[2],old_edate.split('-')[1],old_edate.split('-')[0]);
                        new_sdate=trim(form.start_date.value);
                        new_sdate=new Date(new_sdate.split('-')[2],new_sdate.split('-')[1],new_sdate.split('-')[0]);
                        new_edate=trim(form.end_date.value);
                        new_edate=new Date(new_edate.split('-')[2],new_edate.split('-')[1],new_edate.split('-')[0]);


                        if(form.name.value == ""){
                            alert("You must enter name of registration year");
                            form.name.focus();
                        }else if(trim(form.start_date.value) == "" ){
                            alert("You must enter start date");
                            form.start_date.focus();
                        }else if(chk!="" && (old_edate.getTime()!=new_sdate.getTime()) ){
                            alert("Start Date must be "+form.prev_end_date.value);
                            form.start_date.focus();
                        }else if(new_sdate.getTime()>=new_edate.getTime()){
                            alert("End date must be greater than Start date");
                            form.start_date.focus();
                        }else if(trim(form.end_date.value) == ""){
                            alert("You must enter End date");
                            form.end_date.focus();
                        }else {
                                submitform( pressbutton );
                        }
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Registration Year of Members :
                        <small>
                        <?php echo $row->id ? 'Edit' : 'New';  ?>
                        </small>
                        </th>
                </tr>
                </table>

                <table width="100%">
                <tr>
                        <td valign="top" width="100%">
                                <table class="adminform">
                                <tr>
                                        <th colspan="3">
                                        Registration Year details <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                <tr>
                                <tr>
                                        <td align=right>
                                        * Name :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="name" value="<?php echo stripslashes($row->name); ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * Start Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="start_date" id="start_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->start_date); ?>  " size="45" maxlength="255" readonly=true />
                                       <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        </td>
                                </tr>

                                <tr>
                                        <td align=right>
                                        * End Date :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="end_date" id="end_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->end_date); ?>  " size="45" maxlength="255"  readonly=true  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        </td>
                                </tr>
                                <!--tr>
                                        <td align=right>
                                        Ordering:
                                        </td>
                                        <td>
                                        <?php echo $lists['ordering']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Access Level:
                                        </td>
                                        <td>
                                        <?php echo $lists['access']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Published:
                                        </td>
                                        <td>
                                        <?php echo $lists['published']; ?>
                                        </td>
                                </tr-->
                                <tr>
                                        <td valign="top" align=right>
                                        Description :
                                        </td>
                                        <td colspan="2">
                                        <?php
                                        // parameters : areaname, content, hidden field, width, height, rows, cols
                                        editorArea( 'description',  stripslashes($row->description) , 'description', '80%;', '200', '60', '20' ) ; ?>
                                        </td>
                                </tr>
                                </table>
                        </td>
                        <!-- Menu Link
                        <td valign="top" width="40%">
                        <?php
                        if ( $row->id > 0 ) {
                    ?>
                                <table class="adminform">
                                <tr>
                                        <th colspan="2">
                                        Link to Menu
                                        </th>
                                <tr>
                                <tr>
                                        <td colspan="2">
                                        This will create a new menu item in the menu you select
                                        <br /><br />
                                        </td>
                                <tr>
                                <tr>
                                        <td valign="top" width="100px">
                                        Select a Menu
                                        </td>
                                        <td>
                                        <?php echo $lists['menuselect']; ?>
                                        </td>
                                <tr>
                                <tr>
                                        <td valign="top" width="100px">
                                        Select Menu Type
                                        </td>
                                        <td>
                                        <?php echo $lists['link_type']; ?>
                                        </td>
                                <tr>
                                <tr>
                                        <td valign="top" width="100px">
                                        Menu Item Name
                                        </td>
                                        <td>
                                        <input type="text" name="link_name" class="inputbox" value="" size="25" />
                                        </td>
                                <tr>
                                <tr>
                                        <td>
                                        </td>
                                        <td>
                                        <input name="menu_link" type="button" class="button" value="Link to Menu" onClick="submitbutton('menulink');" />
                                        </td>
                                <tr>
                                <tr>
                                        <th colspan="2">
                                        Existing Menu Links
                                        </th>
                                </tr>
                                <?php
                                if ( $menus == NULL ) {
                                        ?>
                                        <tr>
                                                <td colspan="2">
                                                None
                                                </td>
                                        </tr>
                                        <?php
                                } else {
                                        mosCommonHTML::menuLinksSecCat( $menus );
                                }
                                ?>
                                <tr>
                                        <td colspan="2">
                                        </td>
                                </tr>
                                </table>
                        <?php
                        } else {
                        ?>
                        <table class="adminform" width="40%">
                                <tr><th>&nbsp;</th></tr>
                                <tr><td>Menu links available when saved</td></tr>
                        </table>
                        <?php
                        }
                        ?>
                        </td>
                        -->
                </tr>
                </table>

                <input type="hidden" name="option" value="com_member_reg_year_bkmea" />
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="prev_end_date" value="<?php echo $prev_end_date; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "start_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "end_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                </script>
                <?php
        }


        /**
        * Form to select Section to move Category to
        */
        function moveMember_reg_yearSelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
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
        function copyMember_reg_yearSelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
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
