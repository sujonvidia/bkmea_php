<?php
/**
* @version $Id: toolbar.config_ccci.html.php,v 1.1 2005/12/04 04:54:38 aslam Exp $
* @package Mambo
* @subpackage Config
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Config
*/
class TOOLBAR_config {
        function _DEFAULT() {
                mosMenuBar::startTable();
                mosMenuBar::save();
                mosMenuBar::spacer();
                //mosMenuBar::apply();
                //mosMenuBar::spacer();
                mosMenuBar::cancel();
        //        mosMenuBar::spacer();
        //        mosMenuBar::help( 'screen.config' );
                mosMenuBar::endTable();
        }
}
?>
