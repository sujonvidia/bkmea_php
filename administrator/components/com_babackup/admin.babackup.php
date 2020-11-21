<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: admin.babackup.php,v 1.3 2006/05/14 05:57:48 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Admin Business Layer
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 0.1
* Date: April 2005
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load language
if (file_exists(  $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_babackup/language/'.$GLOBALS['mosConfig_lang'].'.php' )) {
    include_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_babackup/language/'.$GLOBALS['mosConfig_lang'].'.php' );
} else {
    include_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_babackup/language/english.php' );
}

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
    | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_babackup' ))) {
    mosRedirect( 'index2.php', _NOT_AUTH );
}

// assign global folder paths
$baBackupPath     = $GLOBALS['mosConfig_absolute_path'] . '/administrator/components/com_babackup/backups';
$baDownloadPath   = $GLOBALS['mosConfig_live_site']     . '/administrator/components/com_babackup/backups';
$baDBBackupPath   = $GLOBALS['mosConfig_absolute_path'] . '/administrator/backups';
$baDBDownloadPath = $GLOBALS['mosConfig_live_site']     . '/administrator/backups';

// load additional components
require_once( $mainframe->getPath( 'admin_html' ) );

// retrieve row selection from forms
$cid   = mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
    $cid = array(0);
}

// process the workflow selection
switch ($task) {
    case 'generate':
        generateBackup( $cid, $option );
        break;

    case 'generatedb':
        generateDBBackup( $option );
        break;

    case 'confirm':
        confirmBackup( $option );
        break;

    case 'credits':
        showHelp( $option );
        break;

    case 'examine':
        examineBackup( $cid, $option );
        break;

    case 'remove':
        switch (mosGetParam( $_REQUEST, 'type', '' )) {
            case 'files':
                deleteBackups( $cid, $option );
                break;
            case 'db':
                deleteDBBackups( $cid, $option );
                break;
            default:
                showBackups( $option );
                break;
        }

    case 'cancel':
        mosRedirect( 'index2.php' );
        break;

    case 'showdb':
        showDBBackups( $option );
        break;

    case 'show':
    default:
        //showBackups( $option ); 
        showDBBackups( $option );
        break;
}


function showBackups( $option ) {
    /**
     * Generate a selectable list of the files in Backup Folder
     */
    global $baBackupPath, $baDownloadPath;

    // initialise list arrays, directories and files separately and array counters for them
    $d_arr = array(); $d = 0;
    $f_arr = array(); $f = 0;
    $s_arr = array(); $s = 0;

    // obtain the list of backup archive files
    getBackupFiles($d_arr, $f_arr, $s_arr, $d, $f);

    // load presentation layer
    HTML_babackup::showBackups( $f_arr, $s_arr, $baBackupPath, $baDownloadPath, 'Site Archives', 'files', $option );
}

function deleteBackups( $cid, $option ) {
    /**
     * Routine to delete the Backup Sets selected in the list backup sets screen
     */
    global $baBackupPath;

    // Cycle through all the selected Backups and Deleted them
    for ($i=0, $n=count($cid); $i < $n; $i++) {
        if ( !unlink( $baBackupPath.'/'.mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' ) ) ) {
            // redirect to list screen
            $msg = _BIGAPE_BACKUP_DELETE_FILE_FAILED;
            mosRedirect( 'index2.php?option='.$option , $msg );
        }
    }

    // redirect to list screen
    $msg = _BIGAPE_BACKUP_DELETE_FILE_SUCCESS;
    mosRedirect( 'index2.php?option='.$option , $msg );
}

function showDBBackups( $option ) {
    /**
     * Generate a selectable list of the files in DB Backup Folder
     */
    global $baDBBackupPath, $baDBDownloadPath;

    // initialise list arrays, directories and files separately and array counters for them
    $d_arr = array(); $d = 0;
    $f_arr = array(); $f = 0;
    $s_arr = array(); $s = 0;

    // obtain the list of backup archive files
    getDatabaseBackupFiles($d_arr, $f_arr, $s_arr, $d, $f);

    // load presentation layer
    HTML_babackup::showBackups( $f_arr, $s_arr, $baDBBackupPath, $baDBDownloadPath, _BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB, 'db', $option );
}

function deleteDBBackups( $cid, $option ) {
    /**
     * Routine to delete the Database Backup Sets selected in the list database backup sets screen
     */
    global $baDBBackupPath;

    // Cycle through all the selected Backups and Deleted them
    for ($i=0, $n=count($cid); $i < $n; $i++) {
        if ( !unlink( $baDBBackupPath.'/'.mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' ) ) ) {
            // redirect to list screen
            $msg = _BIGAPE_BACKUP_DELETE_FILE_FAILED;
            mosRedirect( 'index2.php?option='.$option.'&task=showdb', $msg );
        }
    }

    // redirect to list screen
    $msg = _BIGAPE_BACKUP_DELETE_FILE_SUCCESS;
    mosRedirect( 'index2.php?option='.$option.'&task=showdb' , $msg );
}

function generateDBBackup( $option ) {
    /**
     * Routine to generate a fresh database backup
     */
    global $baDBBackupPath;

    // extend the exetcution time by 5 minutes
    set_time_limit(300);
    // generate database backup if required
    $tables = array(); $tables[0] = 'all';
    doBackup($tables, 'gzip', 'local', 'both', $_SERVER['HTTP_USER_AGENT'], $baDBBackupPath, $databaseResult );

    // redirect to list screen
    $msg = _BIGAPE_BACKUP_DBBACKUP_SUCCESS;
    mosRedirect( 'index2.php?option='.$option.'&task=showdb' , $msg );
}

function confirmBackup( $option ) {
    /**
     * Routine to display a confirmation screen prior to backup containing the
     * selectable folders and a confirmation for backing up the database
     */
    global $baBackupPath, $mosConfig_absolute_path, $database, $mosConfig_mailfrom, $my;

    // Initialise list arrays, directories and files separately and array counters for them
    $excludedFolders = array();
    $d_arr = array(); $d = 0;
    $ds_arr = array();
    $f_arr = array(); $f = 0;
    $s_arr = array(); $s = 0;
    $d_arr[$d] = $mosConfig_absolute_path;

    // obtain the list of folders by recursing the mambo file store
    recurseFiles($d_arr, $ds_arr, $f_arr, $s_arr, $d, $f, $s, $excludedFolders, '');

    // Get sending email address
    $query = "SELECT email FROM #__users WHERE id='$my->id'";
    $database->setQuery( $query );
    $my->email = $database->loadResult();
    $emailaddress = $my->email;
    if ($emailaddress == '') { $emailaddress = $mosConfig_mailfrom; }

    // load presentation layer
    HTML_babackup::confirmBackups( $d_arr, $ds_arr, $baBackupPath, $emailaddress, $option );
}

function examineBackup( $cid, $option ) {
    /**
     * Routine to exmine the contents of an Archive
     */
    global $baBackupPath, $mosConfig_absolute_path;

    // check that only one file is selected
    if (count($cid) != 1) {
        // redirect to list screen
        $msg = _BIGAPE_BACKUP_SELECT_ONE_FILE;
        mosRedirect( 'index2.php?option='.$option , $msg );
    }

    // load compression related classes
    require_once ($mosConfig_absolute_path."/administrator/components/com_babackup/classes/tar.php");

    // get the selected file
    $filename = $baBackupPath.'/'.mosGetParam( $_REQUEST, 'f'.$cid[0], 'FAILED' );

    // extend the exetcution time by 5 minutes
    set_time_limit(300);

    // read and print tar file contents
    $tar = new Archive_Tar($filename);
    if (($arr = $tar->listContent()) != 0) {

        // load presentation layer
        HTML_babackup::examineBackups( $arr, mosGetParam( $_REQUEST, 'f'.$cid[0], 'FAILED' ), $option );

    } else {

        // redirect to list screen
        $msg = _BIGAPE_BACKUP_ERROR_GETTING_CONTENTS;
        mosRedirect( 'index2.php?option='.$option , $msg );

    }
}

function generateBackup( $cid, $option ) {
    /**
     * Routine to generate recurse a folder structure and record the files, their sizes and parent folders
     */
    global $baBackupPath, $mosConfig_absolute_path, $mosConfig_secret, $baDBBackupPath;
    global $mosConfig_mailfrom, $mosConfig_fromname;

    // load compression related classes
    require_once ($mosConfig_absolute_path."/administrator/components/com_babackup/classes/tar.php");

    // generate database backup if required
    $backupDatabase = mosGetParam( $_REQUEST, 'dbbackup', 'unknown' );
    if ($backupDatabase == 1) {
        // extend the exetcution time by 5 minutes
        set_time_limit(300);
        $tables = array(); $tables[0] = 'all';
        doBackup($tables, 'gzip', 'local', 'both', $_SERVER['HTTP_USER_AGENT'], $baDBBackupPath, $databaseResult );
    } else {
        $databaseResult = _BIGAPE_BACKUP_DATABASE_EXCLUDED;
    }

    // obtain list of folders included in the backup
    $includedFolders = array();
    for ($i=0, $n=count($cid); $i < $n; $i++) {
        $includedFolders[] = mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' );
    }

    // initialise list arrays, directories and files separately and array counters for them
    $d_arr  = array(); $d = 0;
    $ds_arr = array();
    $f_arr  = array(); $f = 0;
    $s_arr  = array(); $s = 0;

    // obtain the list of files by recursing the mambo file store
    recurseFiles($d_arr, $ds_arr, $f_arr, $s_arr, $d, $f, $s, $includedFolders, '');

    // format total archive size
    $originalSize = getFileSizeText($s);

    // extend the file locations to include the full path
    for( $i=0; $i < count( $f_arr ); $i++ ) {
        $f_arr[$i] = $mosConfig_absolute_path.'/'.$f_arr[$i];
    }

    // generate the backup set filename
    //$domainname = strtolower(str_replace('.','_',$_SERVER['HTTP_HOST']));
    $filename1  = date("Ymdhis").'_backup_'.$mosConfig_secret.'.tar.gz';
    $filename   = $baBackupPath.'/'.$filename1;

    // extend the exetcution time by 5 minutes
    set_time_limit(300);

    // create the Tar file from the fileset array
    $tarArchive = new Archive_Tar($filename, "gz");
    $tarArchive->createModify($f_arr, '', $mosConfig_absolute_path) or die("Could not create archive!");

    // format the compressed size of the fileset
    $archiveSize = getFileSizeText(filesize($filename));

    // email the archive
    $emailResult = _BIGAPE_BACKUP_EMAIL_EXCLUDED;
    $emailArchive = mosGetParam( $_REQUEST, 'emailenabled', 'unknown' );
    if ($emailArchive == 1) {

        // extend the exetcution time by 5 minutes
        set_time_limit(300);

        // validate the email address
        $emailAddress = mosGetParam( $_REQUEST, 'emailaddress', '' );
        if ( (trim($emailAddress) != "") && (preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $emailAddress ) == true) ) {

            // email the file
            $emailMessage  = $filename1.' ('.$archiveSize.')';
            $emailMessage .= "\n\nWith compliments from bigAPE Development | www.bigape.co.uk\n\n";
            if ( mosMail( $mosConfig_mailfrom, $mosConfig_fromname, $emailAddress, $_SERVER['HTTP_HOST'].' - '._BIGAPE_BACKUP_EMAIL_SUBJECT, _BIGAPE_BACKUP_EMAIL_MESSAGE."\n\n   ".$emailMessage, 0, NULL, NULL, $filename) ) {
                $emailResult = _BIGAPE_BACKUP_EMAIL_COMPLETED;
            } else {
                $emailResult = _BIGAPE_BACKUP_EMAIL_FAILED;
            }

        }
    }

    // load presentation layer
    HTML_babackup::generateBackup($filename1, $archiveSize, $originalSize, count($includedFolders), $f, $databaseResult, $emailResult, $option );
}

function showHelp( $option ) {
    /**
     * Display the Help Screen
     */

    // load presentation layer
    HTML_babackup::showHelp( $option );
}


function recurseFiles(&$d_arr, &$ds_arr, &$f_arr, &$s_arr, &$d, &$f, &$s, &$includedFolders, $path) {
    /**
     * Routine to recurse a folder structure and record the files their sizes and parent folders
    */
    global $mosConfig_absolute_path, $baBackupPath;

    $currentfullpath = $mosConfig_absolute_path.$path;
    // Open possibly available directory
    if( is_dir( $currentfullpath ) ) {
        if( $handle = @opendir( $currentfullpath ) ) {
            while( false !== ( $file = readdir( $handle ) ) ) {
                // Make sure we don't push parental directories or dotfiles (unix) into the arrays
                if( $file != "." && $file != "..") {
                    if( is_dir( $currentfullpath . "/" . $file ) ) {
                        // Create array for directories
                        $d_arr[++$d] = $currentfullpath . "/" . $file;
                        recurseFiles($d_arr, $ds_arr, $f_arr, $s_arr, $d, $f, $s, $includedFolders, $path . "/" . $file);
                    } else {
                        if ( in_array($currentfullpath, $includedFolders) ) {
                            // Create array for files
                            $s_arr[$f] = filesize($currentfullpath.'/'.$file);
                            $f_arr[$f++] = str_replace($mosConfig_absolute_path.'/', '', $currentfullpath.'/').$file;
                            $s += filesize($currentfullpath.'/'.$file);
                        }
                    }
                }
            }
        }
        // Wrap things up if we're in a directory
        if( is_dir( $handle ) )
            closedir( $handle );
    }
}


function getBackupFiles(&$d_arr, &$f_arr, &$s_arr, &$d, &$f) {
    /**
     * Routine to list the existing backup files in the Component Backup folder
     */
    global $baBackupPath;

    $path = $baBackupPath;
    // Open possibly available directory
    if( is_dir( $path ) ) {
        if( $handle = opendir( $path ) ) {
            while( false !== ( $file = readdir( $handle ) ) ) {
                // Make sure we don't push parental directories or dotfiles (unix) into the arrays
                if( $file != "." && $file != ".." && $file[0] != "." ) {
                    if( is_dir( $path . "/" . $file ) )
                        // Create array for directories
                        $d_arr[$d++] = $file;
                    else
                        if ($file != 'index.html') {
                            // Create array for files
                            $f_arr[$f++] = $file;
                        }
                }
            }
        }
    }

    // Wrap things up if we're in a directory
    if( is_dir( $handle ) )
        closedir( $handle );

    // Print file list
    for( $i=0; $i < count( $f_arr ); $i++ ) {
        $s_arr[$i] = getFileSizeText(filesize( $path . "/" . $f_arr[$i] ));
    }
}

function getDatabaseBackupFiles(&$d_arr, &$f_arr, &$s_arr, &$d, &$f) {
    /**
     * Routine to list the existing database backup files in the Mambo Backup folder
     */
    global $baDBBackupPath;

    $path = $baDBBackupPath;
    // Open possibly available directory
    if( is_dir( $path ) ) {
        if( $handle = opendir( $path ) ) {
            while( false !== ( $file = readdir( $handle ) ) ) {
                // Make sure we don't push parental directories or dotfiles (unix) into the arrays
                if( $file != "." && $file != ".." && $file[0] != "." ) {
                    if( is_dir( $path . "/" . $file ) )
                        // Create array for directories
                        $d_arr[$d++] = $file;
                    else
                        if ($file != 'index.html') {
                            // Create array for files
                            $f_arr[$f++] = $file;
                        }
                }
            }
        }
    }

    // Wrap things up if we're in a directory
    if( is_dir( $handle ) )
        closedir( $handle );

    // Print file list
    for( $i=0; $i < count( $f_arr ); $i++ ) {
        $s_arr[$i] = getFileSizeText(filesize( $path . "/" . $f_arr[$i] ));
    }
}


function getFileSizeText($filesize) {
    /**
     * Routine to display a formatted version of a filesize
     */
    return baBackupTools::getFileSizeText($filesize);
}


function doBackup( $tables, $OutType, $OutDest, $toBackUp, $UserAgent, $local_backup_path, &$databaseResult) {
    /**
     * Backup Routine for Mambo mySQL database
     * Recovered from the AdvInstall Component by Jilin Fima
     * <JFima> fima@nm.ru Which we believe was based on the
     * original backup source from MOS 4.5
     */
    global $database, $mosConfig_db, $mosConfig_sitename, $mosConfig_secret, $version, $option, $task;


    if (!$tables[0])
    {
        $databaseResult = _BIGAPE_BACKUP_DATABASE_MISSING_TABLES;
        return;
    }

    /* Need to know what browser the user has to accomodate nonstandard headers */

    if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $UserAgent)) {
        $UserBrowser = "Opera";
    }
    elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $UserAgent)) {
        $UserBrowser = "IE";
    } else {
        $UserBrowser = '';
    }

    /* Determine the mime type and file extension for the output file */
    $filename  = date("Ymdhis").'_'.$mosConfig_db.'_'.$mosConfig_secret;
    if ($OutType == "bzip") {
        $filename .= ".bz2";
        $mime_type = 'application/x-bzip';
    } elseif ($OutType == "gzip") {
        $filename .= ".sql.gz";
        $mime_type = 'application/x-gzip';
    } elseif ($OutType == "zip") {
        $filename .= ".zip";
        $mime_type = 'application/x-zip';
    } elseif ($OutType == "html") {
        $filename .= ".html";
        $mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
    } else {
        $filename .= ".sql";
        $mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
    };

    /* Store all the tables we want to back-up in variable $tables[] */

    if ($tables[0] == "all") {
        array_pop($tables);
        $database->setQuery("SHOW tables");
        $database->query();
        $tables = array_merge($tables, $database->loadResultArray());
    }

    /* Store the "Create Tables" SQL in variable $CreateTable[$tblval] */
    if ($toBackUp!="data")
    {
        foreach ($tables as $tblval)
        {
            $database->setQuery("SHOW CREATE table $tblval");
            $database->query();
            $CreateTable[$tblval] = $database->loadResultArray(1);
        }
    }

    /* Store all the FIELD TYPES being backed-up (text fields need to be delimited) in variable $FieldType*/
    if ($toBackUp!="structure")
    {
        foreach ($tables as $tblval)
        {
            $database->setQuery("SHOW FIELDS FROM $tblval");
            $database->query();
            $fields = $database->loadObjectList();
            foreach($fields as $field)
            {
                $FieldType[$tblval][$field->Field] = preg_replace("/[(0-9)]/",'', $field->Type);
            }
        }
    }




    /* Build the fancy header on the dump file */
    $OutBuffer = "";
    if ($OutType == 'html') {
    } else {
        $OutBuffer .= "/*\n";     //update by camellia team
        $OutBuffer .= " Host: $mosConfig_sitename\n";
        $OutBuffer .= " Generation Time: " . date("M j, Y \a\\t H:i") . "\n";
        $OutBuffer .= " Server version: " . $database->getVersion() . "\n";
        $OutBuffer .= " PHP Version: " . phpversion() . "\n";
        $OutBuffer .= " Database : `" . $mosConfig_db . "`\n --------------------------------------------------------\n*/\n";
        $OutBuffer .= " create database if not exists `".$mosConfig_db."`; \n";
        $OutBuffer .= " use `".$mosConfig_db."`;\n";
    }

    /* Okay, here's the meat & potatoes */
    foreach ($tables as $tblval) {
        if ($toBackUp != "data") {
            if ($OutType == 'html') {
            } else {
                $OutBuffer .= "/*\n Table structure for table `$tblval`\n*/";
                $OutBuffer .= "\nDROP table IF EXISTS `".$tblval."`;\n";
                $OutBuffer .= $CreateTable[$tblval][0].";\r\n";
            }
        }
        if ($toBackUp != "structure") {
            if ($OutType == 'html') {
                $OutBuffer .= "<div align=\"left\">";
                $OutBuffer .= "<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\">";
                $database->setQuery("SELECT * FROM $tblval");
                $rows = $database->loadObjectList();

                $OutBuffer .= "<tr><th colspan=\"".count( @array_keys( @$rows[0] ) )."\">`$tblval`</th></tr>";
                if (count( $rows )) {
                    $OutBuffer .= "<tr>";
                    foreach($rows[0] as $key => $value) {
                        $OutBuffer .= "<th>$key</th>";
                    }
                    $OutBuffer .= "</tr>";
                }

                foreach($rows as $row)
                {
                    $OutBuffer .= "<tr>";
                    $arr = mosObjectToArray($row);
                    foreach($arr as $key => $value)
                    {
                        $value = addslashes( $value );
                        $value = str_replace( "\n", '\r\n', $value );
                        $value = str_replace( "\r", '', $value );

                        $value = htmlspecialchars( $value );

                        if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET "))
                        {
                            $OutBuffer .= "<td>'$value'</td>";
                        }
                        else
                        {
                            $OutBuffer .= "<td>'$value'</td>";    //single quotation added for null column
                        }
                    }
                    $OutBuffer .= "</tr>";
                }
                $OutBuffer .= "</table></div><br />";
            } else {
                $OutBuffer .= "/*\n-- Dumping data for table `$tblval`\n*/\n";
                $OutBuffer .= "\n\n";
                $database->setQuery("SELECT * FROM $tblval");
                $rows = $database->loadObjectList();
                foreach($rows as $row)
                {
                    $InsertDump = "INSERT INTO `".$tblval."` VALUES (";
                    $arr = mosObjectToArray($row);
                    foreach($arr as $key => $value)
                    {
                        $value = addslashes( $value );
                        $value = str_replace( "\n", '\r\n', $value );
                        $value = str_replace( "\r", '', $value );
                        if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET"))
                        {
                            $InsertDump .= "'$value',";
                        }
                        else
                        {
                            $InsertDump .= "'$value',";      //single quotation added for null column
                        }
                    }
                    $OutBuffer .= rtrim($InsertDump,',') . ");\n";
                }
            }
        }
    }

    /* Send the HTML headers */
    if ($OutDest == "remote") {
        // dump anything in the buffer
        @ob_end_clean();
        ob_start();
        header('Content-Type: ' . $mime_type);
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        if ($UserBrowser == 'IE') {
            header('Content-Disposition: inline; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
        }
    }

    if ($OutDest == "screen" || $OutType == "html" ) {
        if ($OutType == "html") {
                echo $OutBuffer;
        } else {
            $OutBuffer = str_replace("<","&lt;",$OutBuffer);
            $OutBuffer = str_replace(">","&gt;",$OutBuffer);
            ?>
            <form>
                <textarea rows="20" cols="80" name="sqldump"  style="background-color:#e0e0e0"><?php echo $OutBuffer;?></textarea>
                <br />
                <input type="button" onClick="javascript:this.form.sqldump.focus();this.form.sqldump.select();" class="button" value="Select All" />
            </form>
            <?php
        }
        exit();
    }

    switch ($OutType) {
        case "sql" :
            if ($OutDest == "local") {
                $fp = fopen("$local_backup_path/$filename", "w");
                if (!$fp) {
                    $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_FAILED;
                    return;
                } else {
                    fwrite($fp, $OutBuffer);
                    fclose($fp);
                    $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                    return;
                }
            } else {
                echo $OutBuffer;
                ob_end_flush();
                ob_start();
                // do no more
                exit();
            }
            break;
        case "bzip" :
            if (function_exists('bzcompress')) {
                if ($OutDest == "local") {
                    $fp = fopen("$local_backup_path/$filename", "wb");
                    if (!$fp) {
                        $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_FAILED;
                    } else {
                        fwrite($fp, bzcompress($OutBuffer));
                        fclose($fp);
                        $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                        return;
                    }
                } else {
                    echo bzcompress($OutBuffer);
                    ob_end_flush();
                    ob_start();
                    // do no more
                    exit();
                }
            } else {
                echo $OutBuffer;
            }
            break;
        case "gzip" :
            if (function_exists('gzencode')) {
                if ($OutDest == "local") {
                    $fp = gzopen("$local_backup_path/$filename", "wb");
                    if (!$fp) {
                        $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_FAILED;
                        return;
                    } else {
                        gzwrite($fp,$OutBuffer);
                        gzclose($fp);
                        $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                        return;
                    }
                } else {
                    echo gzencode($OutBuffer);
                    ob_end_flush();
                    ob_start();
                    // do no more
                    exit();
                }
            } else {
                echo $OutBuffer;
            }
            break;
        case "zip" :
            if (function_exists('gzcompress')) {
                global $mosConfig_absolute_path;
                //include $mosConfig_absolute_path.'/administrator/components/com_babackup/classes/pcl/zip.lib.php';
                //$zipfile = new zipfile();
                //$zipfile -> addFile($OutBuffer, $filename . ".sql");
            }
            switch ($OutDest) {
                case "local" :
                    $fp = fopen("$local_backup_path/$filename", "wb");
                    if (!$fp) {
                        $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_FAILED;
                        return;
                    } else {
                        fwrite($fp, $zipfile->file());
                        fclose($fp);
                        $databaseResult = _BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED.' ( '.getFileSizeText(filesize($local_backup_path.'/'.$filename)).' )';
                        return;
                    }
                    break;
                case "remote" :
                    echo $zipfile->file();
                    ob_end_flush();
                    ob_start();
                    // do no more
                    exit();
                    break;
                default :
                    echo $OutBuffer;
                    break;
            }
            break;
    }
}


/**
* @package Mambo
* @subpackage baBackup
*/
class baBackupTools {

    function getFileSizeText($filesize) {
        /**
         * Routine to display a formatted version of a filesize
         */

        if( $filesize >= 1024 && $filesize < 1048576) {
            // Size in kilobytes
            return round( $filesize / 1024, 2 ) . " KB";
        } elseif( $filesize >= 1048576 ) {
            // Size in megabytes
            return round( $filesize / 1024 / 1024, 2 ) . " MB";
        } else {
            // Size in bytes
            return $filesize . " bytes";
        }
    }

}

?>
