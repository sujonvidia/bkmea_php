<?php
/**
* @version $Id: admin.voter_scci.html.php,v 1.4 2006/02/23 07:05:01 morshed Exp $
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
class voter_html {


        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                 <?php echo "Print&nbsp;".$image; ?>
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
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_voter_scci&amp;do_pdf=1&amp;last_reg_id='+'<?php echo $last_reg_id; ?>';
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
                        Voter from Duplicate TIN 
                        </th>
                        <td  align=right>
                                        <?php
                                            //voter_html::PdfIcon(  );
                                        ?>
                        </td>
                        <td>
                        &nbsp;&nbsp;&nbsp;Filter :
                        </td>
                        <td>
                        <input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
                        </td>
                        <td width="right">
                        <?php echo $lists['search_tin'];   ?>
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
                        <th class="name" align="left" width=18%>
                        Membership Code
                        </th>
                        <th class="title" align=left width=30%>
                        Firm Name
                        </th>

                        <th class="name" align=left width=20%>
                        Applicant Name
                        </th>

                        <th class="name" align=left width=15%>
                        Member Type
                        </th>



                        <th class="name" align="center" width=10%>
                        Tin Number
                        </th>

                        <th class="name" align=center width=7%>
                        Is Voter
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row         = &$rows[$i];

                        $link = 'index2.php?option=com_voter_scci&task=editA&hidemainmenu=1&id='. $row->id;
                        $checked         = mosCommonHTML::CheckedOutProcessing( $row, $i );
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
                                <td align="left">
                                <?php echo $row->member_reg_no;?>
                                </td>
                                <td>
                                <!--a href="<?php echo $link; ?>" -->
                                <?php echo stripslashes($row->companyname); ?>
                                <!--/a-->
                                </td>

                                <td >
                                <?php echo stripslashes($row->title)." ".stripslashes($row->name)." ".stripslashes($row->last_name); ?>
                                </td>

                                <td >
                                <?php echo stripslashes($row->member_type);?>
                                </td>

                                <td align="center">
                                <?php echo $row->tin;?>
                                </td>

                                <?php
                                if ( $row->is_voter ) {
                                        ?>
                                        <td align="center">
                                        <img src="images/tick.png">
                                        </td>
                                        <?php
                                } else {
                                        ?>
                                        <td align="center">
                                        <img src="images/publish_x.png">
                                        </td>
                                        <?php
                                }
                                ?>
                                <?php

                                $k = 1 - $k;
                                ?>
                        </tr>
                        <?php
                }
                ?>
                </table>

                <?php echo $pageNav->getListFooter(); ?>

                <input type="hidden" name="option" value="com_voter_scci" />
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
