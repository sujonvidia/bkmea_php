<?php
/**
* @version $Id: admin.delegate_voter_ccci.html.php,v 1.5 2006/01/31 03:40:10 morshed Exp $
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
class Delegate_voter_html {


        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                 <?php echo "View&nbsp;".$image; ?>
                </a>
        <?php
        }

        /**
        * Writes a list of the categories for a section
        * @param array An array of category objects
        * @param string The name of the category section
        */
         function show( &$rows, &$pageNav, &$lists, &$search) {
                global $my, $mosConfig_live_site;
                $last_reg_id=$_SESSION['working_reg_year_id'];
                mosCommonHTML::loadOverlib();
                ?>
                <script language="javascript" type="text/javascript">

                function createPdfLink(){
                      var form, link, status;

                      form = document.adminForm;

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_delegate_voter_ccci&amp;do_pdf=1&amp;last_reg_id='+'<?php echo $last_reg_id; ?>';
                      void window.open(link, 'win2', status);

                }

                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        submitform( pressbutton );
                }
                </script>

                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Delegate Member Voter List
                        </th>
                        <td  align=right>
                                        <?php
                                            Delegate_voter_html::PdfIcon(  );
                                        ?>
                        </td>
                        <td>
                        &nbsp;&nbsp;&nbsp;Filter :
                        </td>
                        <td>
                        <input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
                        </td>
                        <td width="right">
                        <?php //echo $lists['search_type_id'];
                        ?>
                        </td>
                </tr>
                </table>


                <table class="adminlist">
                <tr>
                        <th width="2" align="left">

                        </th>


                        <th width="5" align="left">
                        #
                        </th>
                        <th width="20">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
                        </th>
                        <th class="title" align=left>
                        Firm Name
                        </th>

                        <th class="name" align=left>
                        Applicant Name
                        </th>

                        <th class="name" align=left>
                        Member Type
                        </th>

                        <th class="name" align=left>
                        Belongs To
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_delegate_voter_ccci&task=editA&hidemainmenu=1&id='. $row->id;

                        $access         = mosCommonHTML::AccessProcessing( $row, $i );
                        $checked         = mosCommonHTML::CheckedOutProcessing_Delegate_voter( $row, $i );
                        $published         = mosCommonHTML::PublishedProcessing( $row, $i );
                        ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>
                                </td>
                                <td>
                                <?php echo $pageNav->rowNumber( $i ); ?>
                                </td>
                                <td>
                                <?php echo $checked; ?>
                                </td>
                                <td>
                                <!--a href="<?php echo $link; ?>" -->
                                <?php echo stripslashes($row->companyname); ?>
                                <!--/a-->
                                </td>

                                <td >
                                <?php echo stripslashes($row->person); ?>
                                </td>

                                <td >
                                <?php echo stripslashes($row->member_type);?>
                                </td>
                                <td >
                                <?php echo stripslashes($row->ParentName);?>
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

                <input type="hidden" name="option" value="com_delegate_voter_ccci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="chosen" value="" />
                <input type="hidden" name="act" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

}
?>
