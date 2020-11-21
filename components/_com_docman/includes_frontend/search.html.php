<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: search.html.php,v 1.4 2006/05/09 07:11:46 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

if (defined('_DOCMAN_HTML_SEARCH')) {
    return;
} else {
    define('_DOCMAN_HTML_SEARCH', 1);
}

class HTML_DMSearch
{
    function searchForm(&$lists, $search_phrase)
    {
        global $_DOCMAN;

        $action = _taskLink('search_result');

        ob_start();
        ?>
                <form action="<?php echo $action;?>" method="post" name="adminForm" id="dm_frmsearch" class="dm_form">

                <table class="" width="100%">
                        <tr>
                                <td nowrap="nowrap" width="20%">
                                Keyword
                                <input type="text" class="inputbox" id="search_phrase" name="search_phrase"  value="<?php echo $search_phrase ?>" />
                                &nbsp;&nbsp;Search in
                                </td>
                                <td nowrap="nowrap" width="45%">
                                 <?php echo $lists['search_type']; ?>
                                </td>
                                <td nowrap="nowrap"  width="35%">

                                </td>
                        </tr>
                        <tr>
                                <td nowrap="nowrap" >
                                <input type="hidden" name="catid" value="-1">
                                <?php echo _DML_SEARCH_MODE;?>
                                <?php echo $lists['searchphrase']; ?>
                                <?php echo $lists['invert_search'] . _DML_NOT ;?>
                                <?php echo '&nbsp;' . $lists['search_mode']?>
                                <input type="submit" class="button" value="<?php echo _DML_SEARCH;?>" />
                                </td>
                                <td nowrap="nowrap">
                                </td>
                                <td nowrap="nowrap">

                                </td>
                        </tr>
                </table>
                </form>
                <?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

?>