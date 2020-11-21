<?php
/**
* @version $Id: admin.board_of_director.html.php,v 1.1 2006/12/28 08:54:00 morshed Exp $
* @package Mambo
* @subpackage ManageMemeberInfoUd
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
class HTML_BoardOfDirector {

        function showBoardOfDirector( &$rows, $pageNav, $search, $option,$lists ) {
                global $mosconfig_show_date_format_short,$database;
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
                    Board of Director
                  </th>
                  <td align="center">
                    Filter:
                    <input type="text" name="search" value="<?php echo stripslashes($search);?>" class="inputbox" />
                   <?php echo $lists['filter_type']; ?>
                  </td>
                  <td align="right" ><?php mosLoadAdminModule( 'toolbar' );?></td>
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
                        <th class="title" width="20%" align="left">
                        Member Reg. No
                        </th>
                        <th class="title" width="25%" align="left">
                        Name
                        </th>
                        <th class="title" width="35%" align="left">
                        Email Address
                        </th>
                        <th width="8%" align="center">
                        Category
                        </th>
                        <th width="7%" align="center">
                        Select
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row    = &$rows[$i];
                        $img         = $row->is_active ? 'tick.png' : 'publish_x.png';
                        $alt         = $row->is_active ? 'Selected' : '';

                        $query="SELECT name from #__member_category where id=".$row->member_category_id;
                        $database->setQuery( $query );
                        $rowCategorys = $database->loadObjectList();
                        $rowCategory=$rowCategorys[0];


                        $link   = 'index2.php?option='. $option . '&amp;task=edit&amp;id='. $row->id;
                        $checked= mosCommonHTML::CheckedOutProcessing( $row, $i );
                ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                                <td align="center"><?php echo $checked; ?></td>
                                <td>
                                <a href="<?php echo $link; ?>">
                                <?php echo $row->member_reg_no; ?>
                                </a>
                                </td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->email_address; ?></td>
                                <td align="center"><?php echo $rowCategory->name; ?></td>
                                <td align="center">
                                <img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                                </td>
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

        function editBoardOfDirector( &$row, &$lists, $option, $uid ) {
                global $my,$task;
                global $mosConfig_live_site;
                $member=trim($_REQUEST['member']);

                ?>
                <script language="javascript" type="text/javascript">
                var enterComments=false;
                function memberSearchWindow(){
                        var page;
                        var form = document.adminForm;
                        page='./popups/searchExistingMemberForManage.php?formName=adminForm';
                        newWin=window.open(page,'','width=800,height=400,scrollbars=yes,resizable=no,top=180,left=150,status=no,menubar=no,directories=no,location=no,toolbar=no');
                        newWin.focus();
                }

                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        if (form.email_address.value == "") {
                                alert( "You must enter email address." );
                                form.email_address.focus();
                        }else {
                                submitform( pressbutton );
                        }
                }

              </script>

          <form action="index2.php" method="post" name="adminForm">
          <table class="adminheading">
                <tr>
                  <th class="categories">
                    Board of Director / <?php echo ucfirst($task); ?>
                  </th>
                  <td align="right" ><?php mosLoadAdminModule( 'toolbar' );?></td>
                </tr>
         </table>
                <table width="100%" class="adminform">
                <tr>
                  <th align="left" colspan="2">
                    Board of Director
                  </th>
                </tr>
                                <tr>
                                        <td  align="right" width="25%">
                                        Membership No :
                                        </td>
                                        <td width="75%" >
                                        <input type="text" name="member_reg_no" class="inputbox" size="25" maxlength="25" value="<?php echo $row->member_reg_no; ?>" />
                                        &nbsp;
                                        <a href="javascript:memberSearchWindow();" onMouseOver="javascript:window.status='Search Existing Member'; return true"><u><b>Search Member</b></u></a>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Member Category :
                                        </td>
                                        <td>
                                        <?php echo $lists['member_category_id']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Name :
                                        </td>
                                        <td >
                                        <input type="text" name="name" class="inputbox" size="50" maxlength="20" value="<?php echo $row->name; ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        * Email Address :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="email_address" id="email_address" value="<?php echo $row->email_address; ?>" size="50"   />

                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                                <div align="right">Select :</div>
                                        </td>
                                        <td align ="left">
                                             <?php echo $lists['is_active']; ?>
                                        </td>
                                </tr>
                     </table>

                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="member" value="<?php echo $member; ?>" />
                <input type="hidden" name="task" value="" />
                         </form>
                <?php


        }
}
?>

