<?php
/**
* @version $Id: toolbar.mail_merge_ccci.php,v 1.1 2006/02/06 10:03:30 nnabi Exp $
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
                TOOLBAR_member_type::_EDIT();
                break;

        case 'moveselect':
                TOOLBAR_member_type::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_member_type::_COPY();
                break;

        default:
                TOOLBAR_member_type::_DEFAULT();
                break;
}
?>
