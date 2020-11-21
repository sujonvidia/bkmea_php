<?php
/**
* @version $Id: toolbar.delegate_voter_ccci.php,v 1.1 2005/12/24 11:41:47 morshed Exp $
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
                TOOLBAR_Delegate_voter::_EDIT();
                break;

        case 'preview':
                TOOLBAR_Delegate_voter::_PREVIEW();
                break;

        case 'moveselect':
                TOOLBAR_Delegate_voter::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_Delegate_voter::_COPY();
                break;

        default:
                TOOLBAR_Delegate_voter::_DEFAULT();
                break;
}
?>
