<?php
/**
* @version $Id: mod_toolbar.php,v 1.4 2005/01/06 01:13:25 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( "$mosConfig_absolute_path/administrator/includes/menubar.html.php" );

if ($path = $mainframe->getPath( "toolbar" )) {
        include_once( $path );
}
?>
