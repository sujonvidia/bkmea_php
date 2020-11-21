<?php
/**
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: english.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
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
defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

// -- General ----------------------------------------------------------------------
DEFINE("_BIGAPE_BACKUP_COM_TITLE"                 , "Site Backup");
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "Confirm Folder Selection");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "Archive Files");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "Database Archives");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "Examine Archive");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "Backup Options");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "Backup Complete");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "Backup Set");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "Download");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "Size of Set");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "Date of Backup");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "Folders");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "Mode");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "Last Modified");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Type");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "File(s) Deleted");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "Deletion of file(s) FAILED");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "Download this Backup Set");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "Database Backup Created");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>Warning</b><br/>Your PHP.INI file is configured with <b>Safe Mode</b> enabled. This component attempts to extend the maximum script execution time to 5 minutes to allow for the backup of larger file systems, however Safe Mode disables this action and your current PHP settings will cause this backup process to exit with an error if it takes longer than <u>{1} seconds</u>. This can be extended by altering the \"max_execution_time\" setting in PHP.INI");

DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "Arhcive Name");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "Number of Folders");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "Number of Files");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "Size of Original File");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "Size of Archive");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "Database Backup");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "Email Delivery");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "Please select one archive file only");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "Error examining Archive contents");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "Examining contents of file ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>Instructions</b><br/>Please select the folders you wish to archive<br/><i>Please be aware that the storage folder for this backup solution is not selected by default</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "Backup database and include in this backup set");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "Send a copy of the Archive to this address when finished");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Excluded");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "Error: Table Definitions Not Found");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "Backup FAILED");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "Backup Completed");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "Not Enabled");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "Email Delivery Failed");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "Completed");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "bigAPE Site Backup - Archive Delivery");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "Attached is the following archive:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "Back");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "Continue");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "Cancel");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , 'Generate Backup');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , 'Examine Backup');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE Backup</h2>
      <b>Background</b><br/>
      During the management of several Mambo sites we came across the need to archive the entire Mambo file system and<br/>database archive into a single compressed archive.
      <br/><br/>
      <b>Solution</b><br/>
      We have attempted to use existing Mambo API features where possible and have implemented a basic full site backup system.<br/>
      The component does not have a client facing interface and all functionality is managed through the administration screens.<br/>
      The component has been developed to be as simple to use as possible.
      <br/><br/>
      <b>Compatibility</b><br/>
      We have tested this component against the following Mambo configurations:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (untested)</li>
      <li>Mambo v4.5.1 (or above)</li>
      </ul>
      <b>Features</b><br/>
      The Component provides a site backup capability. The following features are currently offered:<ul>
      <li>Ability to backup the entire Mambo file and database system to a compressed file.</li>
      <li>Ability to select which folders to include and exclude from the backup</li>
      <li>Ability to download & manage archives of the Mambo file system</li>
      <li>Ability to generate, download & manage archives of the Mambo mySQL database</li>
      <li>Archives files are unqiue to the Mambo installation based on creation time and secret key</li>
      <li>Backup excludes existing backup sets to conserve space</li>
      </ul>
      <b>User Guide</b><br/>
      The Component User Guide is included in the installation package - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>bigAPE Backup User Guide (PDF)</b></a><br/>
      <br/><br/>
      <b>Translations</b><br/>
      The following people have been kind enough to donate their translation ability:<ul>
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


