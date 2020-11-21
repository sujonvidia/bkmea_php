<?php
/**
* @version $Id: toolbar.circulation.php,v 1.2 2006/11/21 05:41:42 aslam Exp $
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
                TOOLBAR_Circulation::_EDIT();
                break;

        default:
                TOOLBAR_Circulation::_DEFAULT();
                break;
}
?>
