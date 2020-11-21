<?php
/**
* @version $Id: admin.hscode_registration.html.php,v 1.4 2007/03/19 07:10:02 aslam Exp $
* @package Mambo
* @subpackage HsCodeRegistrationUd
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Author: Morshed Alam
* Date: 22-08-2006
*/
class HTML_HsCodeRegistrationUd {

        function showHsCodeRegistrationUd( &$rows, $pageNav, $search, $option,$lists ) {
                global $mosconfig_show_date_format_short;
                ?>
                <script language="javascript" type="text/javascript">
                function searchValidation(){
                        var keyObj=document.getElementById('search');
                        var typeObj=document.getElementById('filter_type');
                        var keyword=keyObj.value;
                        var type=typeObj.value;
                        if (keyword=='' && type !=0){
                        alert("You must assign keyword.");
                        keyObj.focus();
                        return;
                        }
                   document.adminForm.submit( );
                }
                </script>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                  <th class="categories">
                    HS Code List
                  </th>
                  <td align="right">
                    Filter:
                    <input type="text" name="search" value="<?php echo stripslashes($search);?>" class="inputbox" />
                    <?php echo $lists['filter_type']; ?>
                  </td>
                </tr>
                </table>
                <table class="adminlist">
                <tr>
                        <th width="2%" class="title">
                        &nbsp;#
                        </th>
                        <th width="3%" class="title" >
                        <div align="center"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" /></div>
                        </th>
                        <th class="title">
                        HS Code
                        </th>
                        <th class="title">
                        Commercial Name
                        </th>

                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row    = &$rows[$i];
                        $img         = $row->is_service ? 'tick.png' : 'publish_x.png';
                        $task         = $row->is_service ? 'unpublish' : 'publish';
                        $alt         = $row->is_service ? 'Publish' : 'Unpublish';
                        $link   = 'index2.php?option=' . $option . '&amp;task=edit&amp;id='. $row->id;
                        $checked= mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $memberRegYear = substr($row->member_reg_date,0,4);
                ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                                <td align="center"><?php echo $checked; ?></td>
                                <td>
                                <a href="<?php echo $link; ?>">
                                <?php echo $row->hscode; ?>
                                </a>
                                </td>
                                <td><?php echo $row->name; ?></td>


                       </tr>
                <?php
                $k=1-$k;
                }
                ?>
                </table>
                <?php echo $pageNav->getListFooter(); ?>
                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

          function editHsCodeRegistrationUd( &$row, &$lists, $option, $uid ) {
                global $my, $acl, $task;
                global $mosConfig_live_site;
                global $mosconfig_calender_date_format;
                ?>
                <script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/ud.js" type="text/javascript"></script>
                <script language="javascript" type="text/javascript">

                function submitbutton(pressbutton) {
                        var submit=0;
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

                        var id='<?php echo $row->id;?>';
                        if (form.hscode.value == '') {
                                alert( "You must provide a HS Code." );
                                form.hscode.focus();
                        }else if (form.name.value == '') {
                                alert( "You must provide a Commercial Name." );
                                form.name.focus();
                        }
                        /*
                        else if (form.description.value == '') {
                                alert( "You must provide a description name." );
                                form.description.focus();
                        }
                        */else {
                                submitform( pressbutton);
                        }
                }

              </script>

          <form action="index2.php" method="post" name="adminForm">
          <table class="adminheading">
                <tr>
                  <th class="categories">
                    HS Code Registration / <?php echo ucfirst($task); ?>
                  </th>

                  <td align="right" ><?php mosLoadAdminModule( 'toolbar' );?></td>
                </tr>
         </table>
                <table width="100%" class="adminform">
                <tr>
                  <th align="left">
                    HS Code Registration
                  </th>
                </tr>
                <tr>
                        <td width="60%" valign="top">
                                <table border="0" width="100%" >
                                <tr width=100%>
                                        <td align="right">
                                        <div align=right>Parent :</div>
                                        </td>
                                        <td align ="left" >
                                         <?php echo $lists['parent_id']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        <div align=right>* HS Code :</div>
                                        </td>
                                                <td align ="left" >
                                        <input type="text" name="hscode" class="inputbox" size="40" maxlength="15" value="<?php echo stripslashes($row->hscode); ?>" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        <div align=right>* Commercial Name :</div>
                                        </td>
                                                <td align ="left" >
                                        <input type="text" name="name" class="inputbox" size="40" maxlength="50" value="<?php echo stripslashes($row->name); ?>" />
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right" valign="top">
                                        <div align=right> Description :</div>
                                        </td>
                                                <td align ="left" >
                                        <textarea name="description" class="inputbox" rows="5" cols="39" maxlength="255" value=""><?php echo stripslashes($row->description); ?></textarea>
                                        </td>
                                </tr>
                     </table>

                  </td>
              </tr>
          </table>

                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="task" value="" />
          </form>

                <?php


        }
}
?>
