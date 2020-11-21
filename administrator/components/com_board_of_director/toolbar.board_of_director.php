<?php
/**
* @version $Id: toolbar.board_of_director.php,v 1.1 2006/12/28 08:54:00 morshed Exp $
* @package Mambo
* @subpackage Unprocessed_ud
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
        case 'new':
        case 'edit':
        case 'editA':
                TOOLBAR_BoardOfDirector::_EDIT();
                break;

        default:
                TOOLBAR_BoardOfDirector::_DEFAULT();
                break;
}
?>
