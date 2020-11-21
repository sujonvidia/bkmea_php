<?php
/**
* @version $Id: toolbar.member_type_scci.php,v 1.1 2005/12/04 04:58:29 aslam Exp $
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

