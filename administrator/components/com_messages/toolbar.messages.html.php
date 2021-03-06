<?php
/**
* @version $Id: toolbar.messages.html.php,v 1.7 2005/02/16 05:14:54 kochp Exp $
* @package Mambo
* @subpackage Messages
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Messages
*/
class TOOLBAR_messages {
	function _VIEW() {
		mosMenuBar::startTable();
		mosMenuBar::customX('reply', 'restore.png', 'restore_f2.png', 'Reply', false );
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save( 'save', 'Send' );
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.messages.edit' );
		mosMenuBar::endTable();
	}

	function _CONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::save( 'saveconfig' );
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelconfig' );
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.messages.conf' );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNewX();
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::help( 'screen.messages.inbox' );
		mosMenuBar::endTable();
	}
}
?>