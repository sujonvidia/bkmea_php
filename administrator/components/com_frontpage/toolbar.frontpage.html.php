<?php
/**
* @version $Id: toolbar.frontpage.html.php,v 1.6 2005/02/16 05:14:52 kochp Exp $
* @package Mambo
* @subpackage Content
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Content
*/
class TOOLBAR_FrontPage {
        function _DEFAULT() {
                mosMenuBar::startTable();
                mosMenuBar::publishList();
                mosMenuBar::spacer();
                mosMenuBar::unpublishList();
                mosMenuBar::spacer();
                mosMenuBar::archiveList();
                mosMenuBar::spacer();
                mosMenuBar::custom('remove','delete.png','delete_f2.png','Remove', true);
        //        mosMenuBar::spacer();
        //        mosMenuBar::help( 'screen.frontpage' );
                mosMenuBar::endTable();
        }
}
?>