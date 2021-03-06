<?php
/**
* @version $Id: mod_pathway.php,v 1.5 2005/02/13 10:59:17 stingrey Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_sitename;

if ($option != '') {
        $html = '';

        $html .= '<div class="pathway">';
        $html .= '<a href="'. $mosConfig_live_site .'/administrator/index2.php">';
        $html .= '<strong>' . $mosConfig_sitename . '</strong>';
        $html .= "</a>";

        if ($option != '') {
                $html .= " / ";
                // try to miss edit functions
                if (strtolower(trim($task))=="stats")  // added by camellia team
                    $task='';                          // added by camellia team
                if ($task != '' && !eregi( 'edit', $task )) {
                        $html .= "<a href=\"index2.php?option=$option\">$option</a>";
                } else {
                        $html .= $option;
                }
        }

        if ($task != '') {
                $html .= " / $task";
        }
        $html .= '</div>';
        echo $html;
}
?>
