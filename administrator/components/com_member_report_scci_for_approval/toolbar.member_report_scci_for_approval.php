<?php
/**
* @version $Id: toolbar.member_report_scci_for_approval.php,v 1.1 2006/07/16 11:31:48 morshed Exp $
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
                TOOLBAR_member_report_for_approval::_EDIT();
                break;

        case 'moveselect':
                TOOLBAR_member_report_for_approval::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_member_report_for_approval::_COPY();
                break;

        default:
                TOOLBAR_member_report_for_approval::_DEFAULT();
                break;
}
?>
