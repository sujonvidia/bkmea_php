<?php

/**
* Sets the page title.
* 
* $Id: Savant2_Plugin_pagetitle.php,v 1.1 2006/03/19 07:02:12 morshed Exp $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
* 
*/

require_once dirname(__FILE__) . '/Plugin.php';

class Savant2_Plugin_pagetitle extends Savant2_Plugin 
{
    /**
    * Sets the page title.
    * 
    * @access public 
    * @return string 
    */

    function plugin($title)
    {
        global $mainframe;
        $mainframe->setPageTitle($title);
        return;
    } 
} 
?>
