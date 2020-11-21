<?php
/**
* @version $Id: toolbar.all_member_report_bkmea.html.php,v 1.1 2006/07/05 06:35:27 morshed Exp $
* @package Mambo
* @subpackage Categories
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/**
* @package Mambo
* @subpackage Categories
*/
class TOOLBAR_member_type {
        /**
        * Draws the menu for Editing an existing category
        * @param int The published state (to display the inverse button)
        */
        function _DEFAULT(){
                mosMenuBar::startTable();
                mosMenuBar::spacer();
                mosMenuBar::endTable();
        }
}
?>
