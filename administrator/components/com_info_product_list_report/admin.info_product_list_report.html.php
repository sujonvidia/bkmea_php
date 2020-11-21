<?php
/**
* @version $Id: admin.info_product_list_report.html.php,v 1.4 2007/01/10 12:16:04 morshed Exp $
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
class info_Product_List_Report_html {

        /*
        *  create PDF link and print PDF Icon
        */
        function PdfIcon(  ) {
                global $mosConfig_live_site;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                View&nbsp;<?php echo $image; ?>
                </a>
        <?php
        }

        /**
        * Writes the edit form for new and existing categories
        * @param mosCategory The category object
        * @param string
        * @param array
        */
        function View( &$lists,$option) {
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format;
                global $for, $mosConfig_owner;

                ?>
                <script language="javascript" type="text/javascript">

                function createPdfLink(){
                      var form, link, status, info_product,info_product_category, report_for, date_from='', date_to='';

                      form = document.adminForm;
                      info_product    = form.info_product.value;
                      info_product_category    = form.info_product_category.value;

                     //if(report_for!=3){
                        date_from  = trim(form.date_from.value);
                        date_to    = trim(form.date_to.value);
                        var from = new Date(date_from.split('-')[2],date_from.split('-')[1],date_from.split('-')[0]);
                        var to   = new Date(date_to.split('-')[2],date_to.split('-')[1],date_to.split('-')[0]);

                        if(date_from!="" && date_to!="" && from.getTime()>to.getTime()){
                              alert("Date To must be greater than Date From("+date_from+")");
                              form.date_from.focus();
                              return;
                        }

                      //}
                      last_reg_year_id = <?php echo intval($_SESSION['working_reg_year_id']); ?>;

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_info_product_list_report&amp;do_pdf=1&amp;info_product_category='+info_product_category+'&amp;date_from='+date_from+'&amp;date_to='+date_to+'&amp;last_reg_year_id='+last_reg_year_id+'&amp;info_product='+info_product+'&amp;for='+'<?php echo $for; ?>';
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
                        <?php if(trim(strtolower($mosConfig_owner))=="epb"){ echo "Trade Leads Report"; } else{ echo "Info Products Report"; } ?>

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
                                        <b><?php echo trim(strtolower($mosConfig_owner))!="epb"?"Info Products Report":"Trade Leads Report"; ?>     </b>
                                        </td>
                                        <td  width=18% align=right>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                               <?php if(trim(strtolower($mosConfig_owner))!="epb"){ ?>
                                <tr width=100%>
                                        <td  width="25%" align="right">
                                        <div align=right>Info Product Category :</div>
                                        </td>
                                        <td width="75%">
                                        <?php echo $lists['info_product_category']; ?>
                                        </td>
                               </tr>
                               <?php }else{ ?>
                               <input type="hidden" name="info_product_category" value="-1">
                               <?php } ?>
                                <tr width=100%>
                                        <td  width="25%" align="right">
                                        <div align=right><?php echo trim(strtolower($mosConfig_owner))!="epb"?"Info Products :":"Trade Leads :"; ?></div>
                                        </td>
                                        <td width="75%">
                                        <?php echo $lists['info_product']; ?>
                                        </td>
                               </tr>

                               <tr width=100%>
                                        <td   align="right">
                                        <div align=right>Date From :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="date_from" id="date_from" value="<?php echo mosHTML::ConvertDateDisplayShort($date_from); ?>" size="25"  readonly=true />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">

                                        </td>
                                </tr>
                               <tr width=100%>
                                        <td   align="right">
                                        <div align=right>Date To :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="date_to" id="date_to" value="<?php echo mosHTML::ConvertDateDisplayShort($date_to); ?>" size="25"  readonly=true />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">

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
                                            info_Product_List_Report_html::PdfIcon(  );
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

                <input type="hidden" name="option" value="com_info_product_list_report" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php if($for!=1){    ?>
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



}
?>
