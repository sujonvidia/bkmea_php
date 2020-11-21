<?php
/**
* @version $Id: contact.html.php,v 1.11 2005/02/16 13:37:39 stingrey Exp $
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
                                                <?php echo _ORG_NAME; ?><br>
                                                <?php echo _ADDRESS_EPB; ?><br><br></td>
                                                </tr>
                                                <tr>
                                                <td>Contact</td>
                                                <td><?php echo _CONTACT_NUMBER_EPB; ?></td>
                                                </tr>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td>E-mail</td>
                                                <td><a href="mailto:<?php echo _EMAIL_EPB_FOR_FRONT; ?>" target="_blank" class="mailtotext"><?php echo _EMAIL_EPB_FOR_FRONT; ?></a></td>
                                                </tr>
                                                <tr>
                                                <td width="12%">Website</td>
                                                <td width="88%"><a href="<?php echo _WEB_EPB_FOR_FRONT; ?>" class="mailtotext"> <?php echo _WEB_EPB_FOR_FRONT; ?></a></td>
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