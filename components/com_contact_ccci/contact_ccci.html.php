<?php
/**
* @version $Id: contact_ccci.html.php,v 1.4 2006/05/17 05:50:23 morshed Exp $
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
                                        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                                <br>
                                                Chittagong Chamber of Commerce &amp; Industry<br>
                                                Chamber House, 38 Agrabad C/A, Chittagong, Bangladesh.<br><br></td>
                                                </tr>
                                                <tr>
                                                <td>Tel.</td>
                                                <td>88-031-713366 </td>
                                                </tr>
                                                <tr>
                                                <td>Fax</td>
                                                <td>88-031-710183</td>
                                                </tr>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td>E-mail</td>
                                                <td><a href="mailto:ccci@globalctg.net" target="_blank" class="mailtotext">ccci@globalctg.net</a></td>
                                                </tr>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td><a href="mailto:ccci@spnetctg.com" class="mailtotext">ccci@spnetctg.com</a></td>
                                                </tr>
                                                <tr>
                                                <td width="12%">Website</td>
                                                <td width="88%"><a href="http://www.chittagongchamber.com" class="mailtotext"> www.chittagongchamber.com</a></td>
                                                </tr>
                                        </table>
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
