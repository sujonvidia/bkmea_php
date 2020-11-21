<?php
/**
* @version $Id: admin.mail_merge_ccci.html.php,v 1.6 2006/08/27 04:41:29 morshed Exp $
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

                 var arr = new Array();
                   arr[27] ="0";
                   arr[28] ="1";
                   arr[29] ="2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_IntNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 37; j++)
                      {
                        if(str.charAt(i) == arr[j])
                           break;
                      }
                      if(j>36)
                      {

                        alert(msg);
                        var temp = parseInt(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                          form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        form.elements[obj].select();
                        break;
                      }
                   }
                }

                function createPdfLink(){
                      var form, link, status, type_id, report_for, date_from='', date_to='',is_outside=-1,location,membership_no;

                      form = document.adminForm;
                      type_id    = form.type_id.value;
                      report_for = form.report_for.value;
                      //member_category=form.member_category_id.value;
                      membership_no =form.membership_no.value;

                      location = form.location.value;
                      for (var i=0;i<form.is_outside.length;i++){
                          if (form.is_outside[i].checked)
                              is_outside= form.is_outside[i].value;
                      }

                      if(report_for!=3){
                        date_from  = trim(form.date_from.value);
                        date_to    = trim(form.date_to.value);
                        var from = new Date(date_from.split('-')[2],date_from.split('-')[1],date_from.split('-')[0]);
                        var to   = new Date(date_to.split('-')[2],date_to.split('-')[1],date_to.split('-')[0]);

                        if(from.getTime()>to.getTime()){
                            alert("Date To must be greater or equal to Date "+date_from);
                            form.date_from.focus();
                            return;
                        }
                      }
                      last_reg_year_id = <?php echo $_SESSION['working_reg_year_id']; ?>;

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_mail_merge_ccci&amp;do_pdf=1&amp;type_id='+type_id+'&amp;report_for='+report_for+'&amp;date_from='+date_from+'&amp;date_to='+date_to+'&amp;last_reg_year_id='+last_reg_year_id+'&amp;is_outside='+is_outside+'&amp;location='+location+'&amp;membership_no='+membership_no;
                      //alert(link);
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
                        Mail Merge
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
                                        <b>Mail Merge      </b>
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
                                        <div align=right>Report For :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['report_for']; ?>
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Location :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['location']; ?>
                                        </td>
                                </tr>
                                <?php if($for != 1){  ?>
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
                                <?php } ?>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Selected Members :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="membership_no" value="" size="25" />
                                        (Ex. 1,2,3-5,9)
                                        </td>
                                </tr>

                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Is Outside City :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['is_outside']; ?>
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

                <input type="hidden" name="option" value="com_mail_merge_bkmea" />
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
