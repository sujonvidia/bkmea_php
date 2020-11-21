<?php
/**
* @version $Id: admin.member_voterlist_ccci.html.php,v 1.6 2006/02/06 11:14:26 nnabi Exp $
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
class Member_Voterlist_html {

        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                View <?php echo $image; ?>
                </a>
        <?php
        }

        /**
        * Writes the edit form for new and existing categories
        * @param mosCategory The category object
        * @param string
        * @param array
        */
        function View( &$lists) {
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format;

                ?>
                <script language="javascript" type="text/javascript">

                function createPdfLink(){
                      var form, link, status, type_id, report_for, date_from, date_to;

                      form = document.adminForm;
                      type_id    = form.type_id.value;
                      report_for = form.report_for.value;

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_member_voterlist_ccci&amp;do_pdf=1&amp;type_id='+type_id+'&amp;report_for='+report_for+'&amp;last_reg_id=<?php echo $_SESSION["working_reg_year_id"]; ?>';

                      void window.open(link, 'win2', status);





                     // alert(link);

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
                        Member Voter List
                        <small>

                        </small>
                        </th>
                </tr>
                </table>

                <table width="100%">
                <tr>
                        <td valign="top" width="60%">
                                <table class="adminform">
                                <tr>
                                        <th colspan=2>
                                        <table width=100%>
                                        <tr width=100%>
                                        <td width=82% align=center>
                                        <b> Report On Voter List       </b>
                                        </td>
                                        <td  width=18% align=right>
                                       
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                               <tr width=100%>
                                        <td  width="25%" align="right">
                                        <div align=right>Member Type :</div>
                                        </td>
                                        <td width="75%">
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                               </tr>
                               <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Report On :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['report_for']; ?>
                                        </td>
                                </tr>

                                <tr>
                                        <th colspan=2>
                                        <table width=100%>
                                        <tr width=100%>
                                        <td width=82% align=center>

                                        </td>
                                        <td  width=18% align=right>
                                        <?php
                                            Member_Voterlist_html::PdfIcon(  );
                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                               <!--tr width=100%>
                                        <td  height=200 align="right">

                                        </td>
                                        <td >
                                        </td>
                                </tr-->
                                </table>
                        </td>
                </tr>
                </table>

                <input type="hidden" name="option" value="com_member_voterlist_ccci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>

                <?php
        }



}
?>
