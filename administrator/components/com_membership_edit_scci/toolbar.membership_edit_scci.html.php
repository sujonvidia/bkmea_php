<?php
/**
* @version $Id: toolbar.membership_edit_scci.html.php,v 1.1 2006/01/18 05:21:09 sami Exp $
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
class TOOLBAR_Membership {
        function _EDITA($next,$prev) {
                global $id;

                mosMenuBar::startTable();
                //mosMenuBar::save();
                mosMenuBar::spacer();
                mosMenuBar::save();
                //mosMenuBar::navX( 'next1', $next, 'Next' );
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
              //  mosMenuBar::addNewX($task='newA', $alt='New');
                mosMenuBar::spacer();
                mosMenuBar::editListX();
                mosMenuBar::spacer();
              //  mosMenuBar::deleteList();
                mosMenuBar::endTable();
        }
}
?>
