<?php
/**
* @version $Id: registration.php,v 1.4 2005/01/06 01:13:27 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$task = mosGetParam( $_REQUEST, 'task', "" );
require_once( $mainframe->getPath( 'front_html' ) );

switch( $task ) {
        case "lostPassword":
        lostPassForm( $option );
        break;

        case "sendNewPass":
        sendNewPass( $option );
        break;

        case "register":
        //registerForm( $option, $mosConfig_useractivation );
        break;

        case "saveRegistration":
        //saveRegistration( $option );
        break;

        case "activate":
        activate( $option );
        break;
}

function lostPassForm( $option ) {
  global $mainframe;
  $mainframe->SetPageTitle(_PROMPT_PASSWORD);
        HTML_registration::lostPassForm($option);
}

/*function getHints( $option ) {
        global $database, $Itemid;
        global $mosConfig_live_site, $mosConfig_sitename;

        $_live_site = $mosConfig_live_site;
        $_sitename = $mosConfig_sitename;

        // ensure no malicous sql gets past
        $checkusername = trim( mosGetParam( $_POST, 'checkusername', '') );
        $checkusername = $database->getEscaped( $checkusername );
        $confirmEmail = trim( mosGetParam( $_POST, 'confirmEmail', '') );
        $confirmEmail = $database->getEscaped( $confirmEmail );

        $database->setQuery( "SELECT id FROM #__users"
        . "\nWHERE username='$checkusername' AND email='$confirmEmail'"
        );

        if (!($user_id = $database->loadResult()) || !$checkusername || !$confirmEmail) {
                mosRedirect( "index.php?option=$option&task=lostPassword&mosmsg="._ERROR_PASS );
        }
         $database->setQuery( "SELECT hint FROM #__users"
        . "\nWHERE username='$checkusername' AND email='$confirmEmail'"
        );
        $rows = $database->loadObjectList();



}*/


function sendNewPass( $option ) {
        global $database, $Itemid;
        global $mosConfig_live_site, $mosConfig_sitename;
        global $mosConfig_fromname, $mosConfig_mailfrom;

        $_live_site = $mosConfig_live_site;
        $_sitename = $mosConfig_sitename;

        // ensure no malicous sql gets past
        $checkusername = trim( mosGetParam( $_POST, 'checkusername', '') );
        $checkusername = $database->getEscaped( $checkusername );
        $confirmEmail = trim( mosGetParam( $_POST, 'confirmEmail', '') );
        $confirmEmail = $database->getEscaped( $confirmEmail );


        if($_POST['pass']=="Get Hints") // to get the hint added by camelia team
        {
                $database->setQuery( "SELECT hint  FROM #__users"
                         . "\nWHERE username='$checkusername' AND email='$confirmEmail'"
                         );

                $hint_obj = $database->loadObjectList();
                //$hint_obj = $database->loadResult();
                if (!$hint_obj)
                {
                   mosRedirect( "index.php?Itemid=$Itemid&task=lostPassword&option=".$option."&mosmsg=Your User Name OR Email Address Does Not Match ");

                   exit;
                }
                else

               {
                        mosRedirect( "index.php?Itemid=$Itemid&task=lostPassword&option=".$option."&mosmsg=Your Input Hint was : ".$hint_obj[0]->hint);

                        exit;
               }

        }

        $database->setQuery( "SELECT id FROM #__users"
        . "\nWHERE username='$checkusername' AND email='$confirmEmail'"
        );

        if (!($user_id = $database->loadResult()) || !$checkusername || !$confirmEmail) {
                mosRedirect( "index.php?option=$option&task=lostPassword&mosmsg="._ERROR_PASS );
        }

        $database->setQuery( "SELECT name, email FROM #__users"
        . "\n WHERE usertype='superadministrator'" );
        $rows = $database->loadObjectList();
        foreach ($rows AS $row) {
                $adminName = $row->name;
                $adminEmail = $row->email;
        }

        $newpass = mosMakePassword();
        $message = _NEWPASS_MSG;
        eval ("\$message = \"$message\";");
        $subject = _NEWPASS_SUB;
        eval ("\$subject = \"$subject\";");

		$headers =  "From:".$mosConfig_fromname."<".$mosConfig_mailfrom.">";

		mail($confirmEmail,$subject,$message,$headers);

        //mosMail($mosConfig_mailfrom, $mosConfig_fromname, $confirmEmail, $subject, $message);

        $newpass1=$newpass; //newly added line
        $newpass = md5( $newpass );
        $sql = "UPDATE #__users SET password='$newpass' WHERE id='$user_id'";
        $database->setQuery( $sql );
        if (!$database->query()) {
                die("SQL error" . $database->stderr(true));
        }

        //mosRedirect( "index.php?Itemid=$Itemid&mosmsg="._NEWPASS_SENT ); //past one

                mosRedirect( "index.php?Itemid=$Itemid&mosmsg="._NEWPASS_SENT."Your new password is : ".$newpass1 );
}



function registerForm( $option, $useractivation ) {
        global $mainframe, $database, $my, $acl;

        if (!$mainframe->getCfg( 'allowUserRegistration' )) {
                mosNotAuth();
                return;
        }
        $lists=array();
        $lists['gender']             = mosHTML::yesnoRadioList( 'gender', 'class="inputbox" size="1"', 1 ,'Male','Female' );
        $lists['country_id']        = mosAdminMenus::CountryList( 'country_id', $row->country_id  );
        $mainframe->SetPageTitle(_REGISTER_TITLE);
        HTML_registration::registerForm($option, $useractivation, $lists);
}

function saveRegistration( $option ) {
        global $database, $my, $acl;
        global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
        global $mosConfig_mailfrom, $mosConfig_fromname;


        if ($mosConfig_allowUserRegistration=="0") {
                mosNotAuth();
                return;
        }

        $row = new mosUser( $database );

        if (!$row->bind( $_POST, "usertype" )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

        mosMakeHtmlSafe($row);

        $row->id = 0;
        $row->usertype = '';
        $row->gid = $acl->get_group_id('Registered','ARO');

        if ($mosConfig_useractivation=="1") {
                $row->activation = md5( mosMakePassword() );
                $row->block = "1";
        }

        if (!$row->check()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

        $row->password=mosMakePassword();
        $pwd = $row->password;
        $row->password = md5( $row->password );
        $row->registerDate = date("Y-m-d H:i:s");

        if (!$row->store()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        $row->checkin();


        $name = $row->name;
        $email = $row->email;
        $username = $row->username;

        $subject = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
        $subject = html_entity_decode($subject, ENT_QUOTES);
        if ($mosConfig_useractivation=="1"){
                $message = sprintf (_USEND_MSG_ACTIVATE, $name, $mosConfig_sitename, $mosConfig_live_site."/index.php?option=com_registration&task=activate&activation=".$row->activation, $mosConfig_live_site, $username, $pwd);
        } else {
               $message = sprintf (_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site, $username, $pwd); //modified by camellia team
               // $message = sprintf (_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site ); //modified by camellia team
        }

        $message = html_entity_decode($message, ENT_QUOTES);


		$headers =  "From:".$mosConfig_fromname."<".$mosConfig_mailfrom.">";

		mail($email,$subject,$message,$headers);

        /*
        // Send email to user
        if ($mosConfig_mailfrom != "" && $mosConfig_fromname != "") {
                $adminName2 = $mosConfig_fromname;
                $adminEmail2 = $mosConfig_mailfrom;
        } else {
                $database->setQuery( "SELECT name, email FROM #__users"
                ."\n WHERE usertype='superadministrator'" );
                $rows = $database->loadObjectList();
                $row2 = $rows[0];
                $adminName2 = $row2->name;
                $adminEmail2 = $row2->email;
        }

        mosMail($adminEmail2, $adminName2, $email, $subject, $message);

        // Send notification to all administrators
        $subject2 = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
        $message2 = sprintf (_ASEND_MSG, $adminName2, $mosConfig_sitename, $row->name, $email, $username);
        $subject2 = html_entity_decode($subject2, ENT_QUOTES);
        $message2 = html_entity_decode($message2, ENT_QUOTES);

        // get superadministrators id
        $admins = $acl->get_group_objects( 25, 'ARO' );

        foreach ( $admins['users'] AS $id ) {
                $database->setQuery( "SELECT email, sendEmail FROM #__users"
                        ."\n WHERE id='$id'" );
                $rows = $database->loadObjectList();

                $row = $rows[0];

                if ($row->sendEmail) {
                        mosMail($adminEmail2, $adminName2, $row->email, $subject2, $message2);
                }
        }
        */

        if ( $mosConfig_useractivation == "1" ){
                echo _REG_COMPLETE_ACTIVATE;
        } else {
                echo _REG_COMPLETE.' Your Password is '.$pwd;
                //echo _REG_COMPLETE.' Your Password is '.$message;

        }


}

function activate( $option ) {
        global $database;

        $activation = trim( mosGetParam( $_REQUEST, 'activation', '') );

        $database->setQuery( "SELECT id FROM #__users"
        ."\n WHERE activation='$activation' AND block='1'" );
        $result = $database->loadResult();

        if ($result) {
                $database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE activation='$activation' AND block='1'" );
                if (!$database->query()) {
                        echo "SQL error" . $database->stderr(true);
                }
                echo _REG_ACTIVATE_COMPLETE;
        } else {
                echo _REG_ACTIVATE_NOT_FOUND;
        }
}

function is_email($email){
        $rBool=false;

        if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
                $rBool=true;
        }
        return $rBool;
}
?>
