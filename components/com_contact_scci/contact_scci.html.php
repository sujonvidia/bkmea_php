<?php
/**
* @version $Id: contact_scci.html.php,v 1.2 2006/03/06 07:31:56 nnabi Exp $
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
                                                The Sylhet Chamber of Commerce &amp; Industry<br>
                                                Chamber Building, Jail Road, P.O. Box No. 97, Sylhet, Bangladesh. <br><br></td>
                                                </tr>
                                                <tr>
                                                <td>Phone: </td>
                                                <td>(0821) 714403, 716069, 810566</td>
                                                </tr>
                                                <!--tr>
                                                <td>Fax</td>
                                                <td>880-31-710183</td>
                                                </tr-->
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td>E-mail</td>
                                                <td><a href="mailto:info@sylhetchamber.org" target="_blank" class="mailtotext">info@sylhetchamber.org</a></td>
                                                </tr>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td><a href="mailto:scci@btsnet.net" class="mailtotext">scci@btsnet.net</a></td>
                                                </tr>
                                                <tr>
                                                <td width="12%">Website</td>
                                                <td width="88%"><a href="http://www.sylhetchamber.org" class="mailtotext"> www.sylhetchamber.org</a></td>
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
