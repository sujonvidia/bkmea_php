<?php
/**
* @version $Id: toolbar.membership_ccci.html.php,v 1.6 2006/01/23 09:29:50 sami Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Weblinks
*/
/*class TOOLBAR_Membership {
        function _EDITA($next,$prev) {
                global $id;

                mosMenuBar::startTable();
                //mosMenuBar::save();
                mosMenuBar::spacer();
                mosMenuBar::navX( 'next1', $next, 'Next' );
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::spacer();
                mosMenuBar::endTable();
        }
        function _EDITB($next,$prev) {
                global $id;

                mosMenuBar::startTable();
                mosMenuBar::spacer();
                mosMenuBar::navX( 'previous', $prev, 'Previous' );
                mosMenuBar::spacer();
                mosMenuBar::navX( 'next1', $next, 'Next' );
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::spacer();
                mosMenuBar::endTable();
        }
        function _EDITC($next,$prev) {
                global $id;

                mosMenuBar::startTable();
                mosMenuBar::spacer();
                mosMenuBar::navX( 'previous', $prev, 'Previous' );
                mosMenuBar::spacer();
                mosMenuBar::navX( 'next1', $next, 'Next' );
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::spacer();
                mosMenuBar::endTable();
        }
        function _PREVIEW($next,$prev) {
                global $id;

                mosMenuBar::startTable();
                mosMenuBar::spacer();
                mosMenuBar::navX( 'previous', $prev, 'Previous' );
                mosMenuBar::spacer();
                mosMenuBar::save();
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::spacer();
                mosMenuBar::endTable();
        }
        function _SAVE() {
                global $id;

                mosMenuBar::startTable();
                mosMenuBar::spacer();
                mosMenuBar::addNewX($task='newA', $alt='New');
                mosMenuBar::spacer();
                mosMenuBar::cancel("Cancel", "Go To List");
                mosMenuBar::endTable();
        }
        function _DEFAULT() {
                mosMenuBar::startTable();
                mosMenuBar::spacer();
                mosMenuBar::addNewX($task='newA', $alt='New');
                mosMenuBar::spacer();
                mosMenuBar::editListX();
                mosMenuBar::spacer();
                mosMenuBar::deleteList();
                mosMenuBar::endTable();
        }
}*/

class TOOLBAR_Membership {
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
               //mosMenuBar::editListX();
               // mosMenuBar::spacer();
               //mosMenuBar::deleteList();
                //mosMenuBar::spacer();
                //mosMenuBar::help( 'screen.categories' );
                mosMenuBar::endTable();
        }
}
?>
