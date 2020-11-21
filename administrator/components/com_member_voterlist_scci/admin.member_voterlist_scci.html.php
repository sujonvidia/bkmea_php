<?php
/**
* @version $Id: admin.member_voterlist_scci.html.php,v 1.9 2006/11/05 05:06:10 morshed Exp $
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
                global $for;
                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
        ?>
                <a href="javascript:createPdfLink();" title="<?php echo _CMN_PDF;?>">
                <?php if ($for==0)
                       echo $image." Print Voter List";
                      else
                        echo $image." Print Voter ID Card";

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
                global $mosConfig_absolute_path, $mosConfig_live_site, $mosconfig_calender_date_format;
                global $for;
                if (intval($for)==0 )
                    $title="Member Voter List";
                else if (intval($for)==1)
                    $title="Member Voter ID Card ";
                ?>
                <script language="javascript" type="text/javascript">

                function createPdfLink(){
                      var form, link, status, type_id, report_for, date_from, date_to;

                      form = document.adminForm;
                      type_id    = form.type_id.value;
                      var membership_no =form.membership_no.value;
                       var pre_final =form.pre_final.value;

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      <?php if ($for==0) { ?>
                            report_for = form.report_for.value;
                            link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_member_voterlist_scci&amp;do_pdf=1&amp;type_id='+type_id+'&amp;report_for='+report_for+'&amp;last_reg_id=<?php echo $_SESSION["working_reg_year_id"]; ?>'+'&amp;membership_no='+membership_no+'&amp;pre_final='+pre_final;
                      <?php } else { ?>
                             link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_member_voterlist_scci&amp;do_pdf=1&amp;type_id='+type_id+'&amp;for=1&amp;last_reg_id=<?php echo $_SESSION["working_reg_year_id"]; ?>'+'&amp;membership_no='+membership_no+'&amp;pre_final='+pre_final;

                      <?php }  ?>
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
                        <?php echo $title;?>
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
                                        <td width=100% align=center>
                                        <b> Repot On <?php echo $title;?>       </b>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                               <tr width=100%>
                                        <td  width="45%" align="right">
                                        <div align=right>Member Type :</div>
                                        </td>
                                        <td width="55%">
                                        <?php echo $lists['type_id']; ?>
                                        </td>
                               </tr>
                               <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Selected Members :</div>
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="membership_no" value="" size="25" />
                                        (Ex. 1,2,3-5,9)
                                        </td>
                                </tr>
                              <?php  if ($for==0) { ?>
                               <tr width=100%>
                                        <td  align="right" width="45%">
                                        <div align=right>Report On :</div>
                                        </td>
                                        <td >
                                        <?php echo $lists['report_for']; ?>
                                        </td>
                                   </tr>
                               <?php  }?>
                                <tr width=100%>
                                        <td  align="right">
                                        <div align=right>Report Title :
                                        </td>
                                        <td >
                                        <input class="text_area" type="text" name="pre_final" size="25" />
                                        ( Preliminary/ Final )
                                        </td>
                                </tr>
                                  <?php  if ($for==0) { ?>

                                  <tr>
                                        <th colspan=2>
                                        <table width=100%>
                                        <tr width=100%>
                                        <td width=100% align=right>
                                         <?php

                                            Member_Voterlist_html::PdfIcon(  );
                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>


                                    <?php  } else {?>
                                       <tr>
                                        <th colspan=2>
                                        <table width=100%>
                                        <tr width=100%>
                                        <td width=100% align=right>
                                         <?php

                                            Member_Voterlist_html::PdfIcon(  );
                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                        </th>
                                <tr>
                                        <?php  } ?>

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

                <input type="hidden" name="option" value="com_member_voterlist_scci" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>

                <?php
        }



}
?>
