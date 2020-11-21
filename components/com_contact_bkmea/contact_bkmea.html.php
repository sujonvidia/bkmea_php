<?php
/**
* @version $Id: contact_bkmea.html.php,v 1.1 2006/02/16 10:53:25 morshed Exp $
* @package Mambo
* @subpackage Contact
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


/**
* @package Mambo
* @subpackage Contact
*/
class HTML_contact {
        function displaylist( &$categories, &$rows, $catid, $currentcat=NULL, &$params, $tabclass ) {
                global $Itemid, $mosConfig_live_site, $hide_js;

                if ( $params->get( 'page_title' ) ) {
                        ?>
                        <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
                        Contact us
                        </div>
                        <?php
                }
                ?>

                <table border="0" width="580" cellspacing="2" cellpadding="2">
                        <tr>
                                <td>
                                        <TABLE class=NormalTextGra cellSpacing=0
                                cellPadding=0 width="100%" hborder="0">
                                <TBODY>
                                <TR>
                                <TD class=NormalTextBold align=left
                                width="30%"><b>Dhaka Office</b></TD>
                                <TD width="70%">National Plaza (4<SUP>th</SUP>
                                Floor) </TD>
                                </TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>1/G, Free School Street, Sonagargaon Road
                                </TD></TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>Dhaka, Bangladesh </TD></TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>&nbsp;</TD></TR>
                                <TR>
                                <TD class=NormalTextBold align=right></TD>
                                <TD><b>Phone:</b> 880-2-9673337, 8620377</TD></TR>
                                <TR>
                                <TD class=NormalTextBold align=right></TD>
                                <TD><b>Fax:</b> 880-2-9673337</TD></TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>&nbsp;</TD></TR>
                                <TR>
                                <TD class=NormalTextBold align=right></TD>
                                <TD><b>E-mail:</b> <A class=mailtotext
                                href="mailto:info@bkmea.com">info@bkmea.com</A></TD></TR>

                                <tr>
                                <TD height=20>  &nbsp;  </TD>
                                </TR>
                                <TR>
                                <TD class=NormalTextBold align=left
                                width="30%"><b>Narayanganj Office</b></TD>
                                <TD width="70%">233/1 Bangabandhu Road</TD>
                                </TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>Press Club Building (1st Floor)
                                </TD></TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>Narayanganj-1400 </TD></TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>&nbsp;</TD></TR>
                                <TR>
                                <TD class=NormalTextBold align=right></TD>
                                <TD><b>Phone:</b> 880-2-7610535, 7611295, 7611857</TD></TR>
                                <TR>
                                <TD class=NormalTextBold align=right></TD>
                                <TD><b>Fax:</b> 880-2-7630609</TD></TR>
                                <TR>
                                <TD>&nbsp;</TD>
                                <TD>&nbsp;</TD></TR>
                                <TR>
                                <TD class=NormalTextBold align=right></TD>
                                <TD><b>E-mail:</b> <A class=mailtotext
                                href="mailto:info@bkmea.com">info@bkmea.com</A></TD></TR>

                                </TBODY>
                                </TABLE>
                                </td>
                        </tr>
                </table>


<?php

        }
        function showCategories( &$params, &$categories, $catid ) {
                global $mosConfig_live_site, $Itemid;
                ?>

                <?php
        }

}
?>
