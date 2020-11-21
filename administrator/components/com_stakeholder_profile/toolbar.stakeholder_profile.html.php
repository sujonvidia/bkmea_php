<?php
/**
* @version $Id: toolbar.stakeholder_profile.html.php,v 1.1 2006/11/21 05:48:41 aslam Exp $
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
class TOOLBAR_StakeHolder {
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
                mosMenuBar::deleteList();
                mosMenuBar::endTable();
        }
}
?>
