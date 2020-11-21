<?php
/**
* @version $Id: toolbar.member_group_town_ccci.html.php,v 1.1 2005/12/24 11:43:01 morshed Exp $
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
class TOOLBAR_member_group_town {
        /**
        * Draws the menu for Editing an existing category
        * @param int The published state (to display the inverse button)
        */
        function _EDIT() {
                global $id;

                mosMenuBar::startTable();
                //mosMenuBar::media_manager();
                mosMenuBar::spacer();
                mosMenuBar::save();
                //mosMenuBar::spacer();
                //mosMenuBar::apply();
                mosMenuBar::spacer();
                if ( $id ) {
                        // for existing content items the button is renamed `close`
                        mosMenuBar::cancel( 'cancel', 'Close' );
                } else {
                        mosMenuBar::cancel();
                }
                //mosMenuBar::spacer();
                //mosMenuBar::help( 'screen.categories.edit' );
                mosMenuBar::endTable();
        }
        /**
        * Draws the menu for Moving existing categories
        * @param int The published state (to display the inverse button)
        */
        function _MOVE() {
                mosMenuBar::startTable();
                mosMenuBar::save( 'movesave' );
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::endTable();
        }
        /**
        * Draws the menu for Copying existing categories
        * @param int The published state (to display the inverse button)
        */
        function _COPY() {
                mosMenuBar::startTable();
                mosMenuBar::save( 'copysave' );
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::endTable();
        }
        /**
        * Draws the menu for Editing an existing category
        */
        function _DEFAULT(){
                $section = mosGetParam( $_REQUEST, 'section', '' );

                mosMenuBar::startTable();
                //mosMenuBar::publishList();
                //mosMenuBar::spacer();
                //mosMenuBar::unpublishList();
                mosMenuBar::spacer();
                mosMenuBar::addNewX();
                mosMenuBar::spacer();
                /*
                if ( $section == 'content' || ( $section > 0 ) ) {
                        mosMenuBar::customX( 'moveselect', 'move.png', 'move_f2.png', 'Move', true );
                        mosMenuBar::spacer();
                        mosMenuBar::customX( 'copyselect', 'copy.png', 'copy_f2.png', 'Copy', true );
                        mosMenuBar::spacer();
                }
                */
                mosMenuBar::editListX();
                mosMenuBar::spacer();
                mosMenuBar::deleteList();
                //mosMenuBar::spacer();
                //mosMenuBar::help( 'screen.categories' );
                mosMenuBar::endTable();
        }
}
?>
