<?php
/**
* @version $Id: toolbar.trade_fair.html.php,v 1.3 2006/12/26 06:30:06 morshed Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Users
*/
class TOOLBAR_TradeFair {
        /**
        * Draws the menu
        */
         function _EDIT() {
                global $id;

                mosMenuBar::startTable();
                mosMenuBar::save();
                mosMenuBar::spacer();
                mosMenuBar::cancel( 'cancel', 'Cancel' );
                mosMenuBar::endTable();
        }

        function _DEFAULT() {
                mosMenuBar::startTable();
                mosMenuBar::addNewX();
                mosMenuBar::spacer();
                mosMenuBar::editListX();
                mosMenuBar::spacer();
                global $my,$mosConfig_owner;
                ($my->usertype=="Manager" && strtolower($mosConfig_owner)=="scci")?"":mosMenuBar::deleteList();
                mosMenuBar::endTable();
        }
}
?>
