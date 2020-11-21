<?php
/**
* @version $Id: toolbar.membership_scci.php,v 1.3 2006/01/22 10:04:43 sami Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

/*switch ($task) {

        case 'new':
        case 'edit':
        case 'newA':
                $next="newB";
                $prev="";
                TOOLBAR_Membership::_EDITA($next,$prev);
                break;
        case 'editA':
                $next="editB";
                $prev="";
                TOOLBAR_Membership::_EDITA($next,$prev);
                break;
        case 'newB':
                $next="newC";
                $prev="newA";
                TOOLBAR_Membership::_EDITB($next,$prev);
                break;
        case 'editB':
                $next="editC";
                $prev="editA";
                TOOLBAR_Membership::_EDITB($next,$prev);
                break;
        case 'newC':
                $next="preview";
                $prev="newB";
                TOOLBAR_Membership::_EDITC($next,$prev);
                break;
        case 'editC':
                $next="preview_";
                $prev="editB";
                TOOLBAR_Membership::_EDITC($next,$prev);
                break;
        case 'preview':
                $next="";
                $prev="newC";
                TOOLBAR_Membership::_PREVIEW($next,$prev);
                break;
        case 'preview_':
                $next="";
                $prev="editC";
                TOOLBAR_Membership::_PREVIEW($next,$prev);
                break;
        case 'save':
                $OPT="newA";
                TOOLBAR_Membership::_SAVE($OPT);
                break;

        default:
                TOOLBAR_Membership::_DEFAULT();
                break;
} */

switch ($task){
        case 'new':
        case 'edit':
        case 'editA':
                TOOLBAR_Membership::_EDIT();
                break;

        case 'moveselect':
                TOOLBAR_Membership::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_Membership::_COPY();
                break;

        default:
                TOOLBAR_Membership::_DEFAULT();
                break;
}
?>
