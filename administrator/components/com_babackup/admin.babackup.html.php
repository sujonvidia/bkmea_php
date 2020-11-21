<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: admin.babackup.html.php,v 1.1 2006/04/09 09:16:58 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Admin Presentation Layer
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 0.1
* Date: April 2005
*/


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage baBackup
*/
class HTML_babackup {

  function showBackups( &$files, &$sizes, $path, $downloadpath, $title, $type, $option ) {
    /**
     * Presentation of the backup set list screen
     */

    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
        <tr><td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo "Camellia - ".$title; ?></td></tr>
    </table>
    <table class="adminlist">
        <tr>
            <th width="5">#</th>
            <th width="5"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $files ); ?>);" /></th>
            <th width="33%" class="title"><?php echo _BIGAPE_BACKUP_COL_FILENAME ?></th>
            <th align="left" width="10%"><?php echo _BIGAPE_BACKUP_COL_DOWNLOAD ?></th>
            <th align="left" width="10%"><?php echo _BIGAPE_BACKUP_COL_SIZE ?></th>
            <th align="left" width="43%"><?php echo _BIGAPE_BACKUP_COL_DATE ?></th>
        </tr>
    <?php
    $k = 0;
    $l=1;
    for ($i=(count( $files )-1); $i >= 0; $i--) {
      $date = date ("D jS M Y H:i:s (\G\M\T O)", filemtime($path.'/'.$files[$i]));
      ?>
        <tr class="<?php echo "row$k"; ?>">
            <td><?php echo $l; ?></td>
            <td align="center"><input type="checkbox" id="cb<?php echo $i ?>" name="cid[]" value="<?php echo $i ?>" onclick="isChecked(this.checked);" /></td>
            <td ><a href="<?php echo $downloadpath.'/'.$files[$i]; ?>"><?php echo $files[$i]; ?></a><input type="hidden" id="f<?php echo $i ?>" name="f<?php echo $i ?>" value="<?php echo $files[$i]; ?>" ></td>
            <td align="left"><a href="<?php echo $downloadpath.'/'.$files[$i]; ?>"><img src="images/filesave.png" border="0" alt="<?php echo _BIGAPE_BACKUP_DOWNLOAD_TITLE ?>" title="<?php echo _BIGAPE_BACKUP_DOWNLOAD_TITLE ?>"></a></td >
            <td align="left"><?php echo $sizes[$i]; ?></td >
            <td align="left"><?php echo $date; ?></td>
        </tr>
      <?php
      $k = 1 - $k;
      $l=$l+1;
    }
    ?>
    </table>
    <input type="hidden" name="option" value="com_babackup" />
    <input type="hidden" name="type" value="<?php echo $type;?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <br/>&nbsp;
    <?php
  }


  function confirmBackups( &$folders, &$sizes, $path, $emailaddress, $option ) {
    /**
     * Presentation of the confirmation screen
     */
    global $baDownloadPath, $mosConfig_absolute_path, $baBackupPath;

    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
        <tr><td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _BIGAPE_BACKUP_COM_TITLE.' - '._BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM; ?></td></tr>
    </table>
    <table class="adminform">
        <tr>
            <td width="50%" valign="top"><?php echo _BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS ?></td>
            <td valign="top">
            <b><?php echo _BIGAPE_BACKUP_DATABASE_ARCHIVE; ?></b><br/><input type="checkbox" id="dbbackup" name="dbbackup" checked value="1" />&nbsp;<?php echo _BIGAPE_BACKUP_CONFIRM_DATABASE; ?><p/>
            <b><?php echo _BIGAPE_BACKUP_EMAIL_ARCHIVE; ?> <span style="color:red;">(BETA)</span></b><br/><input type="checkbox" id="emailenabled" name="emailenabled" value="1" />&nbsp;<?php echo _BIGAPE_BACKUP_CONFIRM_EMAIL; ?>&nbsp;<input type="textbox" size="20" id="emailaddress" name="emailaddress" value="<?php echo $emailaddress; ?>"><br/>
            </td>
        </tr>
    <?php if (ini_get('safe_mode')) {?>
        <tr>
            <td width="50%" ><?php echo str_replace( '{1}', ini_get('max_execution_time'), _BIGAPE_BACKUP_SAFE_MODE_ON);?><br/>&nbsp;</td>
            <td width="50%">&nbsp;</td>
        </tr>
    <?php } ?>
    </table>
    <table class="adminlist">
        <tr>
            <th width="5">#</th>
            <th width="5"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $folders ); ?>);" /></th>
            <th width="99%" class="title"><?php echo _BIGAPE_BACKUP_COL_FOLDER ?></th>
        </tr>
    <?php
    $k = 0;

    for ($i=0; $i <= (count( $folders )-1); $i++) {
      ?>
        <tr class="<?php echo "row$k"; ?>">
            <td><?php echo $i+1; ?></td>
            <td align="center"><input type="checkbox" id="cb<?php echo $i ?>" <?php if ($folders[$i] != $baBackupPath) ?> name="cid[]" value="<?php echo $i ?>" onclick="isChecked(this.checked);" /></td>
            <td <?php if ($folders[$i] == $baBackupPath) echo 'style="color:red;"';?>>
            <?php $currentFolder = str_replace($mosConfig_absolute_path, '', $folders[$i]); if ($currentFolder == '') echo "-- Camellia Root --"; else echo $currentFolder; ?><input type="hidden" id="f<?php echo $i ?>" name="f<?php echo $i ?>" value="<?php echo $folders[$i]; ?>" >
            </td>
        </tr>
      <?php
      $k = 1 - $k;
    }
    ?>
    </table>

    <input type="hidden" name="option" value="com_babackup" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <br/>&nbsp;
    <?php
  }

  function examineBackups( &$contents, &$filename, $option ) {
    /**
     * Presentation of the confirmation screen
     */
    global $baDownloadPath, $mosConfig_absolute_path, $baBackupPath;

    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _BIGAPE_BACKUP_COM_TITLE.' - '._BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE; ?></td>
    </tr>
    </table>
    <table class="adminform">
        <tr><td ><?php echo _BIGAPE_BACKUP_EXAMINING_CONTENTS; ?>&nbsp;<b><?php echo $filename ?></b></td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
    <table class="adminlist">
    <tr>
        <th width="15%" class="title"><?php echo _BIGAPE_BACKUP_COL_FILENAME ?></th>
        <th width="5%" class="title"><?php echo _BIGAPE_BACKUP_COL_SIZE ?></th>
        <th width="5%" class="title">UID</th>
        <th width="5%" class="title">GID</th>
        <th width="5%" class="title"><?php echo _BIGAPE_BACKUP_COL_MODE ?></th>
        <th width="5$" class="title"><?php echo _BIGAPE_BACKUP_COL_MODIFIED ?></th>
        <th width="5%" class="title"><?php echo _BIGAPE_BACKUP_COL_TYPE ?></th>
    </tr>
    <?php
    $k = 0;
    foreach ($contents as $a) {
    ?>
    <tr class="<?php echo "row$k"; ?>">
        <td align="left" nowrap><?php echo $a['filename']; ?></td>
        <td align="left" nowrap><?php echo baBackupTools::getFileSizeText($a['size']); ?></td>
        <td align="left" nowrap><?php echo $a['uid']; ?></td>
        <td align="left" nowrap><?php echo $a['gid']; ?></td>
        <td align="left" nowrap><?php echo $a['mode']; ?></td>
        <td align="left" nowrap><?php echo date ("D jS M Y H:i:s (\G\M\T O)", $a['mtime']); ?></td>
        <td align="left" nowrap><?php if ($a['typeflag'] == 5) { echo "directory"; } else { echo "file"; } ?></td>
    </tr>
    <?php
    }
    ?>
    </table>
    <input type="hidden" name="option" value="com_babackup" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <br/>&nbsp;
    <?php
  }


  function generateBackup( $archiveName, $archiveSize, $originalSize, $d, $f, $databaseResult, $emailResult, $option ) {
    /**
     * Presentation of the final report screen
     */

    ?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
        <tr><td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _BIGAPE_BACKUP_COM_TITLE.' - '._BIGAPE_BACKUP_SCREEN_TITLE_GENERATE; ?></td></tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
        <tr><td width="20%"><strong>&nbsp;</strong></td><td>&nbsp;</td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_ARCHIVE_NAME; ?></strong></td><td><?php echo $archiveName; ?></td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_NUMBER_FOLDERS; ?></strong></td><td><?php echo $d; ?></td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_NUMBER_FILES; ?></strong></td><td><?php echo $f; ?></td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_SIZE_ORIGINAL; ?></strong></td><td><?php echo $originalSize; ?></td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_SIZE_ARCHIVE; ?></strong></td><td><?php echo $archiveSize; ?></td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_DATABASE_ARCHIVE; ?></strong></td><td><?php echo $databaseResult; ?></td></tr>
        <tr><td><strong>&nbsp;<?php echo _BIGAPE_BACKUP_EMAIL_ARCHIVE; ?></strong></td><td><?php echo $emailResult; ?></td></tr>
        <tr><td><strong>&nbsp;</strong></td><td>&nbsp;</td></tr>
    </table>
    <form action="index2.php" name="adminForm" method="post">
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="task" value=""/>
    </form>
    <?php
  }


  function showHelp( $option ) {
    /**
     * Presentation of the Help Screem
     */

    ?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
        <tr><td width="100%" class="sectionname"><img src="images/backup.png" align="middle">&nbsp;<?php echo _BIGAPE_BACKUP_COM_TITLE; ?></td></tr>
    </table>
    <table border="0" align="center" cellspacing="0" cellpadding="2" width="100%" class="adminform">
        <tr>
          <td>
          <?php echo _BIGAPE_BACKUP_COM_HELP; ?>
          <table border=0>
          <tr><th>&nbsp;</th><th>&nbsp;</th></tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          </table>
          </td>
        </tr>
    </table>
    <form action="index2.php" name="adminForm" method="post">
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="task" value=""/>
    </form>
    <?php
  }

}
?>

