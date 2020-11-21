<?php
/**
* @version $Id: admin.member_history_report.html.php,v 1.10 2006/04/26 06:48:44 nnabi Exp $
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
class Member_History_Report_html {

        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site, $mosConfig_owner;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
        <?php
                if($mosConfig_owner=="CCCI" || strtolower($mosConfig_owner)=="bkmea")
                        echo "View ";
                else
                        echo "Print ";
                echo $image;
        ?>
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
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format, $for;

                ?>
                <script language="javascript" type="text/javascript">

                function createPdfLink(){
                      var form, link, status, type_id, report_for, date_from, date_to;

                      form = document.adminForm;
                      type_id    = form.type_id.value;
                      report_for = form.report_for.value;
                      date_from  = trim(form.date_from.value);
                      date_to    = trim(form.date_to.value);

                      if(date_from!="" && date_to!=""){
                            var from = new Date(date_from.split('-')[2],date_from.split('-')[1],date_from.split('-')[0]);
                            var to   = new Date(date_to.split('-')[2],date_to.split('-')[1],date_to.split('-')[0]);

                            if(from.getTime()>to.getTime()){
                               alert("Date To must be greater or equal to Date "+date_from);
                               //form.date_from.focus();
                               return;
                            }
                      }

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_member_history_report&amp;do_pdf=1&amp;type_id='+type_id+'&amp;report_for='+report_for+'&amp;date_from='+date_from+'&amp;date_to='+date_to+'&amp;for='+'<?php echo $for; ?>';
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
                        Member History Report
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
                                        <b>Member History Report      </b>
                                        </td>
                                        <td  width=18% align=right>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                               <tr width=100%>
                                        <td  width="25%" align="right">
                                        <div align=right>User Name :</div>
                                        </td>
                                        <td width="75%">
                                        <?php
                                        echo $lists['type_id'];
                                        ?>
                                        </td>
                               </tr>
                               <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Report For :</div>
                                        </td>
                                        <td >
                                        <?php
                                        echo $lists['report_for'];
                                        ?>
                                        </td>
                                </tr>
                               <tr width=100%>
                                        <td   align="right">
                                        <div align=right>Date From :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="date_from" id="date_from" value="<?php echo mosHTML::ConvertDateDisplayShort($date_from); ?>" size="25"  readonly=true />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
                                        </td>
                                </tr>
                               <tr width=100%>
                                        <td   align="right">
                                        <div align=right>Date To :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="date_to" id="date_to" value="<?php echo mosHTML::ConvertDateDisplayShort($date_to); ?>" size="25"  readonly=true />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        <?php echo mosToolTip('Date Format : dd/mm/yyyy'); ?>
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
                                            Member_History_Report_html::PdfIcon(  );
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

                <input type="hidden" name="option" value="com_member_history_report" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "date_from",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "date_to",      // id of the input field
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
