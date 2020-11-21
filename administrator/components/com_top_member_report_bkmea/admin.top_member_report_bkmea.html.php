<?php
/**
* @version $Id: admin.top_member_report_bkmea.html.php,v 1.1 2006/07/05 06:35:27 morshed Exp $
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
class Member_Report_html {

        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                <?php echo "View ".$image; ?>
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
                global $for;

                ?>
                <script language="javascript" type="text/javascript">

                function createPdfLink(){
                      var order_by, form, link, status,fromYear;

                      form = document.adminForm;
                      
                      fromYear = form.fromYear.value;

                      for (var counter = 0; counter < form.order_by.length; counter++)
                      {
                           if (form.order_by[counter].checked)
                               order_by = form.order_by[counter].value;
                      }

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_top_member_report_bkmea&amp;do_pdf=1&amp;order_by='+order_by+'&amp;fromYear='+fromYear;
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
                <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Top Member Report
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
                                        <b>Top Member Report      </b>
                                        </td>
                                        <td  width=18% align=right>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                                
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Select Year :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['fromYear']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Order By :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['order_by']; ?>
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
                                            Member_Report_html::PdfIcon(  );
                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                                </table>
                        </td>
                </tr>
                </table>

                <input type="hidden" name="option" value="com_member_report_bkmea" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
         <?php      
        }
}
?>
