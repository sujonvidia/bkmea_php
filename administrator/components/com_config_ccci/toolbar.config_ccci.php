<?php
/**
* @version $Id: toolbar.config_ccci.php,v 1.1 2005/12/04 04:54:38 aslam Exp $
* @package Mambo
* @subpackage Config
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	default:
		TOOLBAR_config::_DEFAULT();
		break;
}
?>
