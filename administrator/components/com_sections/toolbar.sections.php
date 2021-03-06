<?php
/**
* @version $Id: toolbar.sections.php,v 1.5 2005/01/06 01:13:23 eddieajau Exp $
* @package Mambo
* @subpackage Sections
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ){
	case 'new':
	case 'edit':
	case 'editA':
		TOOLBAR_sections::_EDIT();
		break;

	case 'copyselect':
		TOOLBAR_sections::_COPY();
		break;

	default:
		TOOLBAR_sections::_DEFAULT();
		break;
}
?>