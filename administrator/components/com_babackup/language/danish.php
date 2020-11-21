<?php
/**
* danish.php 2005/04/12 ot2sen
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: danish.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Language Translation File
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 1.1
* Date: April 2005
*/


// ensure this file is being included by a parent file */
defined( "_VALID_MOS" ) or die( "Direkte adgang til dette sted tillades ikke." );

// -- General ----------------------------------------------------------------------
DEFINE("_BIGAPE_BACKUP_COM_TITLE"                 , "Websted Backup");
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "Bekræft Mappe Valg");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "Arkiv Filer");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "Database Arkiver");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "Gennemse Arkiv");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "Backup Muligheder");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "Backup Komplet");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "Backup Pakke");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "Download");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "Størrelse af Pakke");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "Dato for Backup");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "Mapper");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "Modus");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "Sidst Ændret");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Type");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "Fil(er) Slettet");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "Sletning af fil(er) MISLYKKEDES");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "Download denne Backup Pakke");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "Database Backup Oprettet");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>Advarsel</b><br/>Din PHP.INI fil er konfigureret med <b>Safe Mode</b> aktiveret. Denne komponent forsøger at udvide maksimum script udførelses tiden til 5 minutter for at tillade backup af større filsystemer, men Safe Mode deaktiverer denne handling og dine nuværende PHP indstillinger vil bevirke at backup processen stopper med en fejl hvis det tager længere end <u>{1} sekunder</u>. Dette kan forlænges ved at ændre \"max_execution_time\" indstillingen i PHP.INI");

DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "Arkiv Navn");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "Antal Mapper");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "Antal Filer");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "Størrelse af Original Fil");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "Størrelse af Arkiv");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "Database Backup");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "E-mail Forsendelse");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "Vælg venligst kun en arkivfil");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "Fejl under gennemgang af Arkivindhold");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "Gennemser indhold af fil ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>Instruktioner</b><br/>Vælg venligst de mapper som du ønsker at arkivere<br/><i>Vær opmærksom på at lagermappen for denne backupløsning ikke vælges automatisk</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "Backup databasen og inkluder i denne backup pakke");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "Send en kopi af Arkivet til denne adresse når den er udført");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Undladt");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "Fejl: Tabel Definitioner Ikke Fundet");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "Backup MISLYKKEDES");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "Backup Udført");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "Ikke aktiveret");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "E-mail Forsendelse Mislykkedes");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "Udført");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "bigAPE Websted Backup - Arkiv Forsendelse");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "Vedhæftet er følgende arkiv:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "Tilbage");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "Fortsæt");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "Fortryd");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , 'Lav Backup');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , 'Gennemse Backup');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE Backup</h2>
      <b>Baggrund</b><br/>
      Ved administration af adskillige Mambo websteder opstod behovet for at kunne arkivere hele Mambo filsystemet og<br/>databasen i et enkelt pakket arkiv.
      <br/><br/>
      <b>Løsning</b><br/>
      Vi har forsøgt at anvende eksisterende Mambo API egenskaber såvidt muligt og har implementeret et basis komplet websted backup system.<br/>
      Komponenten har ikke noget klient interface og alle funktioner håndteres via administrations skærmbillederne.<br/>
      Komponenten er udviklet til at være så simpel at anvende som muligt.
      <br/><br/>
      <b>Kompatibilitet</b><br/>
      Vi har testet denne komponent op mod følgende Mambo konfigurationer:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (untested)</li>
      <li>Mambo v4.5.1 (eller højere)</li>
      </ul>
      <b>Egenskaber</b><br/>
      Komponenten giver mulighed for backup af et websted. Følgende egenskaber tilbydes i nuværende version:<ul>
      <li>Mulighed for at tage en backup af hele Mambo fil- og databasesystemet til en pakket fil.</li>
      <li>Mulighed for at vælge hvilke mapper der skal inkluderes/udelades fra backupen</li>
      <li>Mulighed for at downloade & håndtere arkiver fra Mambo filsystemet</li>
      <li>Mulighed for at generere, downloade & håndtere arkiver fra Mambo mySQL databasen</li>
      <li>Arkivfiler er unikke for Mamboinstallationen baseret på oprettelsestid og hemmelig nøgle</li>
      <li>Backup undlader at medtage eksisterende backuppakker for at spare plads</li>
      </ul>
      <b>Bruger Vejledning</b><br/>
      Komponentens Bruger Vejledning er inkluderet i installationpakken - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>bigAPE Backup Bruger Vejledning (eng.) (PDF)</b></a><br/>
      <br/><br/>
      <b>Oversættelse</b><br/>
      følgende personer har været så venlige at donere deres oversættelses evner:<ul>
      <li>Polish - Adam Sobkowicz (www.mambosite.net)</li>
      <li>Hebrew - Elad Shmitank</li>
      <li>French - Benoit Goeyvaerts</li>
      <li>Português Brasileiro - Bruno Carvalho (www.criativ.pro.br)</li>
      <li>Hrvatski - Nikola Milcic</li>
      <li>Danish - Ole Bang Ottosen (www.ot2sen.dk)</li>
      </ul>
      bigAPE Development Ltd &copy; 1998-2005 | <a href="http://www.bigape.co.uk">www.bigape.co.uk</a>
      <br/><p/><br/>
');

?>

