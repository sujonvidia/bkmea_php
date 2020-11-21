<?php
/**
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: french.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
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
DEFINE("_COM_TITLE"                 , "Sauvegarde du site");
DEFINE("_COM_TITLE_CONFIRM"         , "Confirmer la sélection du répertoire");

DEFINE("_SCREEN_TITLE_SHOW"         , "Fichiers d'archive");
DEFINE("_SCREEN_TITLE_SHOWDB"       , "Archives de base de données");
DEFINE("_SCREEN_TITLE_EXAMINE"      , "Examiner l'archive");
DEFINE("_SCREEN_TITLE_CONFIRM"      , "Options de sauvegarde");
DEFINE("_SCREEN_TITLE_GENERATE"     , "Sauvegarde terminée");

DEFINE("_COL_FILENAME"              , "Contenus de la sauvegarde");
DEFINE("_COL_DOWNLOAD"              , "Télécharge");
DEFINE("_COL_SIZE"                  , "Taille de la sauvegarde");
DEFINE("_COL_DATE"                  , "Date de la sauvegarde");
DEFINE("_COL_FOLDER"                , "Répertoires");
DEFINE("_COL_MODE"                  , "Mode");
DEFINE("_COL_MODIFIED"              , "Dernière modifications");
DEFINE("_COL_TYPE"                  , "Type");

DEFINE("_DELETE_FILE_SUCCESS"       , "Fichier(s) effacé(s)");
DEFINE("_DELETE_FILE_FAILED"        , "Effacement fichier(s) Échoué");
DEFINE("_DOWNLOAD_TITLE"            , "Télécharge cette liste de sauvegarde");

DEFINE("_DBBACKUP_SUCCESS"          , "Sauvegarde base de données effectuée !");

DEFINE("_SAFE_MODE_ON"              , "<b>Attention !</b><br/>Votre fichier PHP.INI est configuré avec le <b>Mode sans échec</b> activé. Ce composant essaye d’étendre à 5 minutes le temps maximum d’exécution du script afin de permettre la sauvegarde de gros systèmes de fichiers.  Cependant, le mode sans échec ne permet pas cette action, et donc, vos paramètres PHP actuels causerons l’arrêt, sur erreur, de la procédure de sauvegarde, si cela prend plus de <u>{1} secondes</u>.  Ce temps peut être étendus en modifiant le paramètre : \"max_execution_time\" dans le fichier PHP.INI");

DEFINE("_ARCHIVE_NAME"              , "Nom de l'archive");
DEFINE("_NUMBER_FOLDERS"            , "Nombre de dossiers");
DEFINE("_NUMBER_FILES"              , "Nombre de fichiers");
DEFINE("_SIZE_ORIGINAL"             , "Taille du fichier d'origine");
DEFINE("_SIZE_ARCHIVE"              , "Taille de l'archive");
DEFINE("_DATABASE_ARCHIVE"          , "Sauvegarde base de données");
DEFINE("_EMAIL_ARCHIVE"             , "Email de destination");

DEFINE("_SELECT_ONE_FILE"           , "Sélectionner un seul fichier d'archive SVP");
DEFINE("_ERROR_GETTING_CONTENTS"    , "Erreur d'analyse du contenu de l'archive");
DEFINE("_EXAMINING_CONTENTS"        , "Analyse du contenu du fichier ");

DEFINE("_CONFIRM_INSTRUCTIONS"      , "<b>Instructions</b><br/>Sélectionner les répertoires que vous désirer archivés<br/><i>Avertissement : le répertoire de stockage de cette sauvegarde n’est pas sélectionné par défaut</i>");
DEFINE("_CONFIRM_DATABASE"          , "Sauvegarde la base de données et l’inclus dans le contenu de la sauvegarde");
DEFINE("_CONFIRM_EMAIL"             , "Envoi une copie de l'archive à cette adresse une fois terminé");

DEFINE("_DATABASE_EXCLUDED"         , "Exclus");
DEFINE("_DATABASE_MISSING_TABLES"   , "Erreur : Définitions de table non trouvées");
DEFINE("_DATABASE_BACKUP_FAILED"    , "Sauvegarde Échouée");
DEFINE("_DATABASE_BACKUP_COMPLETED" , "Sauvegarde terminée");

DEFINE("_EMAIL_EXCLUDED"            , "Non activée");
DEFINE("_EMAIL_FAILED"              , "Envoi Email échoué");
DEFINE("_EMAIL_COMPLETED"           , "Terminé");

DEFINE("_EMAIL_SUBJECT"             , "Sauvegarde site bigAPE - Envoi archive");
DEFINE("_EMAIL_MESSAGE"             , "Ci-joint l'archive suivante:");

DEFINE("_MENU_BACK"                 , "Retour");
DEFINE("_MENU_CONTINUE"             , "Suivant");
DEFINE("_MENU_CANCEL"               , "Annulé");
DEFINE("_MENU_GENERATE"             , 'Génération de la sauvegarde');
DEFINE("_MENU_EXAMINE"              , 'Examination de la sauvegarde');

DEFINE("_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE backup</h2>
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


