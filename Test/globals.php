<?php
/**
* @version $Id: globals.php,v 1.2 2005/12/01 08:44:00 sami Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/
//         test
$raw = phpversion();
list($v_Upper,$v_Major,$v_Minor) = explode(".",$raw);

if (($v_Upper == 4 && $v_Major < 1) || $v_Upper < 4) {
        $_FILES = $HTTP_POST_FILES;
        $_ENV = $HTTP_ENV_VARS;
        $_GET = $HTTP_GET_VARS;
        $_POST = $HTTP_POST_VARS;
        $_COOKIE = $HTTP_COOKIE_VARS;
        $_SERVER = $HTTP_SERVER_VARS;
        $_SESSION = $HTTP_SESSION_VARS;
        $_FILES = $HTTP_POST_FILES;
}

if (!ini_get('register_globals')) {
        while(list($key,$value)=each($_FILES)) $GLOBALS[$key]=$value;
        while(list($key,$value)=each($_ENV)) $GLOBALS[$key]=$value;
        while(list($key,$value)=each($_GET)) $GLOBALS[$key]=$value;
        while(list($key,$value)=each($_POST)) $GLOBALS[$key]=$value;
        while(list($key,$value)=each($_COOKIE)) $GLOBALS[$key]=$value;
        while(list($key,$value)=each($_SERVER)) $GLOBALS[$key]=$value;
        while(list($key,$value)=@each($_SESSION)) $GLOBALS[$key]=$value;
        foreach($_FILES as $key => $value){
                $GLOBALS[$key]=$_FILES[$key]['tmp_name'];
                foreach($value as $ext => $value2){
                        $key2 = $key . '_' . $ext;
                        $GLOBALS[$key2] = $value2;
                }
        }
}
?>
