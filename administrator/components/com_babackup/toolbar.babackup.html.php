<?php
/**
* bigAPE Site Backup 0.1 for Mambo CMS
* @version $Id: toolbar.babackup.html.php,v 1.3 2006/05/15 07:38:56 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Toolbar Presentation Layer
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

class TOOLBAR_babackup {

  function _GENERATE() {
    mosMenuBar::startTable();
    mosMenuBar::custom( 'show', 'restore.png', 'restore_f2.png', _BIGAPE_BACKUP_MENU_BACK, false );
    mosMenuBar::endTable();
  }

  function _CONFIRM() {
    mosMenuBar::startTable();
    mosMenuBar::custom( 'generate', 'next.png', 'next_f2.png', _BIGAPE_BACKUP_MENU_CONTINUE, false );
    mosMenuBar::spacer();
    mosMenuBar::custom( 'show', 'cancel.png', 'cancel_f2.png', _BIGAPE_BACKUP_MENU_CANCEL, false );
    mosMenuBar::endTable();
  }

  function _DBBACKUPS() {
    mosMenuBar::startTable();
    mosMenuBar::custom( 'generatedb', 'new.png', 'new_f2.png', 'Backup', false );
    mosMenuBar::spacer();
    mosMenuBar::deleteList();
    //mosMenuBar::spacer();
    //mosMenuBar::custom( 'show', 'cancel.png', 'cancel_f2.png', _BIGAPE_BACKUP_MENU_CANCEL, false );
    mosMenuBar::endTable();
  }

  function _DEFAULT() {
    mosMenuBar::startTable();
    //mosMenuBar::custom( 'confirm', 'new.png', 'new_f2.png', 'Backup', false );
    mosMenuBar::spacer();
    //mosMenuBar::custom( 'examine', 'unarchive.png', 'unarchive_f2.png', _BIGAPE_BACKUP_MENU_EXAMINE, true );
    //mosMenuBar::spacer();
    mosMenuBar::deleteList();
    mosMenuBar::spacer();
    mosMenuBar::cancel();
    mosMenuBar::endTable();
  }
}
?>
