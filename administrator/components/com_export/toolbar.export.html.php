<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class TOOLBAR_babackup
{

  function _DEFAULT() {
    mosMenuBar::startTable();
    mosMenuBar::custom( 'generatedb', 'new.png', 'new_f2.png', 'Processed', false );
    mosMenuBar::spacer();
    global $my,$mosConfig_owner;
    ($my->usertype=="Manager" && strtolower($mosConfig_owner)=="scci")?"":mosMenuBar::deleteList();
    mosMenuBar::endTable();
  }
   
}
?>
