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
			FAQs
			</div>
			<?php
		}
		?>

		<table border="0" width="580" cellspacing="2" cellpadding="2">
			<tr>
				<td class="tableheader">Title</td>
				<td class="tableheader">Name</td>
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