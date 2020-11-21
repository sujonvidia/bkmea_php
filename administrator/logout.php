<?php
/**
* @version $Id: logout.php,v 1.4 2005/01/06 01:13:25 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$currentDate = date("Y-m-d\TH:i:s");

if (isset($_SESSION['session_user_id']) && $_SESSION['session_user_id']!="") {
        $database->setQuery( "UPDATE #__users SET lastvisitDate='$currentDate' WHERE id='" . $_SESSION['session_user_id'] . "'");

        if (!$database->query()) {
        echo $database->stderr();
        }
}

if (isset($_SESSION['session_id']) && $_SESSION['session_id']!="") {
        $database->setQuery( "DELETE FROM #__session WHERE session_id='" . $_SESSION['session_id'] . "'");

        if (!$database->query()) {
                echo $database->stderr();
        }
}

$name = "";
$fullname = "";
$id = "";
$session_id = "";

session_unregister( "session_id" );
session_unregister( "session_user_id" );
session_unregister( "session_username" );
session_unregister( "session_usertype" );
session_unregister( "session_logintime" );

session_unregister("max_reg_year_id");
session_unregister("working_reg_year_id");
session_unregister("working_reg_year_name");


if (session_is_registered( "session_id" )) {
        session_destroy();
}
if (session_is_registered( "session_user_id" )) {
        session_destroy();
}
if (session_is_registered( "session_username" )) {
        session_destroy();
}
if (session_is_registered( "session_usertype" )) {
        session_destroy();
}
if (session_is_registered( "session_logintime" )) {
        session_destroy();
}

if (session_is_registered( "max_reg_year_id" )) {
        session_destroy();
}
if (session_is_registered( "working_reg_year_id" )) {
        session_destroy();
}
if (session_is_registered( "working_reg_year_name" )) {
        session_destroy();
}
mosRedirect( "../index.php" );
?>
