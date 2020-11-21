<?php
/**
* @version $Id: toolbar.type_two_member_report_scci.php,v 1.1 2006/07/13 09:16:38 morshed Exp $
* @package Mambo
* @subpackage Categories
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task){
        case 'new':
        case 'edit':
        case 'editA':
                TOOLBAR_member_report::_EDIT();
                break;

        case 'moveselect':
                TOOLBAR_member_report::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_member_report::_COPY();
                break;

        default:
                TOOLBAR_member_report::_DEFAULT();
                break;
}
?>
