<?php
/**
* @version $Id: toolbar.membership_certificate_scci.php,v 1.1 2005/12/04 05:01:54 aslam Exp $
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
                TOOLBAR_Membership_certificate::_EDIT();
                break;

        case 'preview':
                TOOLBAR_Membership_certificate::_PREVIEW();
                break;

        case 'moveselect':
                TOOLBAR_Membership_certificate::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_Membership_certificate::_COPY();
                break;

        default:
                TOOLBAR_Membership_certificate::_DEFAULT();
                break;
}
?>

