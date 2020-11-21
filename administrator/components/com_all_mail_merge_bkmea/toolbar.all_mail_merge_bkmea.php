<?php
/**
* @version $Id: toolbar.all_mail_merge_bkmea.php,v 1.1 2007/04/08 04:36:44 aslam Exp $
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
                TOOLBAR_all_mail_merge::_EDIT();
                break;

        case 'moveselect':
                TOOLBAR_all_mail_merge::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_all_mail_merge::_COPY();
                break;

        default:
                TOOLBAR_all_mail_merge::_DEFAULT();
                break;
}
?>
