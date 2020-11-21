<?php
/**
* @version $Id: mod_mosmsg.php,v 1.3 2006/09/26 06:33:42 aslam Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$mosmsg = trim( strip_tags( mosGetParam( $_REQUEST, 'mosmsg', '' ) ) );
$errmsg = trim( strip_tags( mosGetParam( $_REQUEST, 'errmsg', '' ) ) );
if ($mosmsg) {
        if (!get_magic_quotes_gpc()) {
                $mosmsg = addslashes( $mosmsg );
        }
        echo "\n<div class=\"message\">".stripslashes($mosmsg)."</div>";
}
if ($errmsg) {
        if (!get_magic_quotes_gpc()) {
                $errmsg = addslashes( $errmsg );
        }
        echo "\n<div class=\"errmessage\">".stripslashes($errmsg)."</div>";
}
?>
