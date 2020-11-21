<?php
/**
* @version $Id: admin.member_type_ccci.html.php,v 1.2 2006/02/19 10:11:33 morshed Exp $
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
class Member_Type_html {

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
                    Member Type
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
                        Name
                        </th>
                        <th class="title" width=60% align=left>
                        Description
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_member_type_ccci&task=editA&hidemainmenu=1&id='. $row->id;

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
                                <a href="<?php echo $link; ?>">
                                <?php echo $row->name ; ?>
                                </a>
                                </td>
                                <td >
                                <?php echo $row->description ; ?>
                                </a>
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

                <input type="hidden" name="option" value="com_member_type_ccci" />
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
                mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
                ?>
                <script language="javascript" type="text/javascript">
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        if(form.name.value == ""){
                            alert("Please enter member type name");
                            form.name.focus();
                        }else if(form.description.value == ""){
                            alert("Enter member type description");
                            form.description.focus();
                        }else {
                                submitform( pressbutton );
                        }
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Member Type :
                        <small>
                        <?php echo $row->id ? 'Edit' : 'New';  ?>
                        </small>
                        </th>
                </tr>
                </table>

                <table width="100%">
                <tr>
                        <td valign="top" width="60%">
                                <table class="adminform">
                                <tr>
                                        <th colspan="3">
                                        Member Type Information  <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                <tr>
                                <tr>
                                        <td align=right >
                                        * Name :
                                        </td>
                                        <td colspan="2">
                                        <input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255"  />
                                        </td>
                                </tr>
                                <!--tr>
                                        <td align=right >
                                        Ordering:
                                        </td>
                                        <td>
                                        <?php echo $lists['ordering']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right >
                                        Access Level:
                                        </td>
                                        <td>
                                        <?php echo $lists['access']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right >
                                        Published:
                                        </td>
                                        <td>
                                        <?php echo $lists['published']; ?>
                                        </td>
                                </tr-->
                                <tr>
                                        <td valign="top" align=right >
                                        * Description :
                                        </td>
                                        <td colspan="2">
                                        <?php
                                        // parameters : areaname, content, hidden field, width, height, rows, cols
                                        editorArea( 'description',  $row->description , 'description', '80%;', '200', '60', '20' ) ;
                                        ?>
                                        </td>
                                </tr>
                                </table>
                        </td>
                        <!--
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

                <input type="hidden" name="option" value="com_member_type_ccci" />
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }



}
?>
